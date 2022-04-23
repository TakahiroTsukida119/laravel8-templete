import dayjs, { Dayjs } from 'dayjs';

/**
 * 昇順で数字の配列を生成する
 * @param min - 最小値
 * @param max - 最大値
 * @returns - min ~ maxの数字を要素に持つ配列
 */
export const createNumberOptions = (min: number, max: number) => {
  const options = [];
  for (let i = min; i <= max; i++) {
    options.push(i);
  }
  return options;
};

/**
 * date → ISO規格
 */
export const formatDateToISO = (date: string | Dayjs): string => {
  return dayjs(date).toISOString();
};

/**
 * ISO規格 → YYYY年M月
 * @param isoDate 日付
 */
export const formatISOToJaMonth = (isoDate: string): string => {
  return dayjs(isoDate).format('YYYY[年]M[月]');
};

/**
 * ISO規格 → YYYY年M月D日
 * @param isoDate 日付
 */
export const formatISOToJaDate = (isoDate: string): string => {
  return dayjs(isoDate).format('YYYY[年]M[月]D[日]');
};

/**
 * ISO規格 → YYYY年M月D日 HH時mm分
 * @param isoDate 日付
 */
export const formatISOToJaDateTime = (isoDate: string): string => {
  return dayjs(isoDate).format('YYYY[年]M[月]D[日] HH[時]mm[分]');
};

/**
 * ISO規格 => YYYY/MM/DD
 * @param isoDate 日付
 */
export const formatISOToSlashDate = (isoDate: string): string => {
  // NOTE: マイページの申し込み物件カードで引き渡し日がnullで受け取る可能性があるため条件分けしている
  if (isoDate === null) {
    return formatNullToHyphen(isoDate) as string;
  }
  return dayjs(isoDate).format('YYYY/MM/DD');
};

/**
 * ISO規格 => YYYY/MM/DD HH:mm(nullの場合は空文字を返す)
 * @param isoDate 日付
 */
export const formatISOToDateTime = (isoDate: string | null): string => {
  return isoDate === null ? '' : dayjs(isoDate).format('YYYY/MM/DD HH:mm');
};

/**
 * ISO規格 => MM日DD HH:mm
 * @param isoDate 日付
 */
export const formatISOToDateJapaneseTime = (isoDate: string | null): string => {
  return isoDate === null ? '' : dayjs(isoDate).format('MM月DD日 HH:mm');
};

/**
 * NOTE: 数字7桁を郵便番号形式(xxx-xxxx)に変換する
 */
export const formatPostcode = (num: number | null): string => {
  // NOTE: 職業が無職 or その他の場合勤務先郵便番号がnullになるので条件分けしている
  if (num === null) return formatNullToHyphen(num) as string;
  const regex = /^\d{7}$/;
  const postcode = num.toString();
  if (regex.test(postcode)) {
    return `${postcode.slice(0, 3)}-${postcode.slice(-4)}`;
  }
  console.error('郵便番号が7桁の半角数字ではない不正な値です');
  return '';
};

/**
 * nullの場合は-を返す。
 */
export const formatNullToHyphen = (
  data: number | string | null,
): number | string => {
  return data === null ? '-' : data;
};

/**
 * 4桁以上の金額にカンマを付与する。
 * null、有限数以外のものが挿入されたらformatNullToHyphenを実行する
 */
export const formatPrice = (
  number: number | string | null,
  unit?: string,
): number | string => {
  if (number === null || !Number.isFinite(number))
    return formatNullToHyphen(number);
  return unit
    ? `${number.toLocaleString('ja')}${unit}`
    : number.toLocaleString('ja');
};

/**
 * 空白文字(スペースやタブなど)を一括削除する処理
 * REVIEW:
 * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
 */
export const formatSpaceDelete = (str: string): string => {
  return str.replace(/\s+/g, '');
};

/**
 * URLエンコードします
 * @param {Object} queryParams Object型で値を渡してください
 */
export const formatQueryString = <T extends object>(queryParams: T): string => {
  const queries = Object.entries(queryParams).map(([key, value]) => ({
    key,
    value,
  }));
  const queryString = queries
    .map((q: { key: string; value: string }, index: number) => {
      const query = `${q.key}=${q.value}`;
      return index === 0 ? `?${query}` : `&${query}`;
    })
    .join('');
  return encodeURI(queryString);
};

/**
 * 文字列をSplitで配列化します
 * @param {string} text
 * @param {string} split
 */
export const splitMap = (text: string, split: string = ',') => {
  return String(text)
    .split(split)
    .map((v: string) => v);
};

/**
 * 文字列のバイト数を返します
 * @param str
 */
export const getBytes = (str: string): number => {
  return encodeURIComponent(str).replace(/%../g, 'x').length;
};

/**
 * 文字省略
 * @param {string} text 対象文字列
 * @param {number} byte バイト数
 * @param {string} ellipsis 文字列の語尾に追加する文字列
 * @returns {string}
 */
export const omitText = (text: string, byte = 80, ellipsis = '...'): string => {
  return getBytes(text) > byte
    ? text.slice(0, byte / 2 - getBytes(ellipsis)) + ellipsis
    : text;
};
