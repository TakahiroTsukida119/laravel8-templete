import { extend } from 'vee-validate';
import { email, is, required } from 'vee-validate/dist/rules';
import dayjs from 'dayjs';
import { formatISOToJaDate } from '../format/format-data';

extend('required', {
  ...required,
  message: 'この入力項目は必須です',
});

extend('email', {
  ...email,
  message: '無効なメールアドレスです',
});

// 指定した文字数以内のみ許容
extend('maxLength', {
  validate(value, max) {
    if (value.length <= max) {
      return true;
    }
    return `${max}文字以下で入力してください`;
  },
});

// 指定した文字数以上のみ許容
extend('minLength', {
  validate(value, min) {
    if (value.length >= min) {
      return true;
    }
    return `${min}文字以上で入力してください`;
  },
});

// ひらがなのみ許容
extend('hiragana', (value) => {
  // eslint-disable-next-line no-irregular-whitespace
  if (value.match(/^[ぁ-ゔー]*$/)) {
    return true;
  }
  return '全角ひらがなで入力してください';
});

/**
 * 数字のルール
 */

// 半角数字のみ許容
extend('number', (value) => {
  const regex = /^[0-9]+$/;
  if (regex.test(value)) {
    return true;
  }
  return '半角数字で入力してください';
});

// 指定した数値を超えた場合にエラー表示(上記のnumberと一緒)
extend('max_value', {
  validate(value, { word, max }: Record<string, any>) {
    if (Number(value) <= Number(max)) {
      return true;
    }

    return `${word}は${max}以下で入力してください`;
  },
  params: ['word', 'max'],
});

// 下限予算を上限予算以上の金額を選択した時のエラー
extend('minimum_budget', {
  validate(value, maximum) {
    if (Number(value) <= Number(maximum) || !Number(maximum)) {
      return true;
    }

    return `上限予算以下の金額を選択してください`;
  },
});

// 郵便番号
extend('postal', (value) => {
  if (value.match(/^[0-9]{7}$/)) {
    return true;
  }
  return '郵便番号は半角数字7文字で入力してください';
});

// 電話番号(7-11文字の半角数字)許容
extend('phoneNumber', (value) => {
  const regex = /^\d{7,11}$/;
  if (regex.test(value)) {
    return true;
  }
  return '電話番号は半角数字7文字〜11文字で入力してください';
});

// 入力された日時が今日以前か確認
extend('isAfterDate', {
  validate(_, { year, month, day }: Record<string, any>) {
    if (Number(year) && Number(month) && Number(day)) {
      const inputDate = dayjs(new Date(year, month - 1, day));
      if (inputDate.isAfter(dayjs(), 'date')) {
        return `今日以前の日付を入力してください`;
      }
    }
    return true;
  },
  params: ['year', 'month', 'day'],
});

// 入力された日時が今日以前か確認
extend('isBeforeDate', {
  validate(_, { minDate, year, month, day }: Record<string, any>) {
    if (Number(year) && Number(month) && Number(day)) {
      const inputDate = dayjs(new Date(year, month - 1, day));
      if (dayjs(minDate).isAfter(inputDate, 'date')) {
        return formatISOToJaDate(dayjs().toISOString()) ===
        formatISOToJaDate(minDate)
          ? '今日以降の日付を入力してください'
          : `${formatISOToJaDate(minDate)}以降を入力してください`;
      }
    }
    return true;
  },
  params: ['minDate', 'year', 'month', 'day'],
});

/**
 * NOTE:
 * 金額のバリデーションルール(万円単位)
 */
extend('money', (value) => {
  if (Number(value) >= 0 && Number(value) <= 200000) {
    return true;
  }

  return '金額は0~200000万円で入力してください';
});

/**
 * NOTE:
 * 上限つき金額バリデーションルール(万円単位)
 * TODO:
 * エラー文言は仮のものです、正式なものが決まれば差し替えてください！
 */
extend('max_money', {
  validate(value, { max }: Record<string, any>) {
    if (Number(value) >= 0 && Number(value) <= Number(max)) {
      return true;
    }

    return `金額は0~${max}万円で入力してください`;
  },
  params: ['max'],
});

/**
 * パスワードのルール
 */

// アルファベット大文字、小文字、数字、記号（!@#$%^&*()+=)のいずれか３種類を含むかどうか
extend('password', (value) => {
  if (value.length < 8 || value.length > 32) {
    return `パスワードは8~32文字以内で入力してください`;
  }
  const regs = [
    /^(?=.*[a-z]).{3,}$/,
    /^(?=.*[A-Z]).{3,}$/,
    /^(?=.*[0-9]).{3,}$/,
    /^(?=.*[!@#$%^&*()+=]).{3,}$/,
  ];
  let matchCount = 0;

  regs.forEach((reg) => reg.test(value) && matchCount++);

  if (matchCount >= 3) {
    return true;
  }
  return 'アルファベット大文字、小文字、数字、記号（!@#$%^&*()+=)のいずれか３種類を必ず含んでください';
});

// 新しいパスワードと再入力が同じか？
extend('isSamePassword', {
  ...is,
  message: 'パスワードが一致しません',
});

/**
 * 以下、使用して居る箇所はないが一応取っておく
 */

// カタカナのみ許容
extend('kana', (value) => {
  // eslint-disable-next-line no-irregular-whitespace
  if (value.match(/^[ア-ン゛゜ァ-ォャ-ョー$\s]+$/)) {
    return true;
  }
  return '全角カタカナで入力してください';
});

// 数字且つマイナス値以外を許容
extend('nonegativenumber', (value) => {
  const regex = /^([1-9]\d*|0)$/;
  if (regex.test(value)) {
    return true;
  }
  return '無効な値です';
});

// 半角カナ、半角英数字、半角記号のみ許容
extend('half', (value) => {
  if (value.match(/^[ -~ｦ-ﾟ0-9]+$/)) {
    return true;
  }
  return '半角カナ・半角数字・記号で入力してください';
});

// 文字列内に空白がある場合を許容しない
extend('noSpace', (value) => {
  const regex = new RegExp(/\s/); /* eslint-disable-line */
  if (value.match(regex)) {
    return `スペース無しで入力してください`;
  }

  return true;
});

