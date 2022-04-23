module.exports = {
    root: true,
    parserOptions: {
        parser: 'babel-eslint',
    },
    env: {
        browser: true,
    },
    extends: [
        'standard',
        'plugin:vue/recommended',
        'plugin:prettier/recommended',
        'prettier/vue',
    ],
    plugins: ['vue', 'prettier'],
    // add your custom rules here
    rules: {
        // ESLintが使用する整形ルールのうち、自分がoffにしたいルールなどを指定する
        'vue/no-v-html': 'off', // v-htmlの使用について
        'vue/prop-name-casing': 'off', // Propsの変数の命名規則について
        'no-console': 'off', // console.log()の使用について
        'no-unused-vars': 'off', // 使われていない変数について
        'camelcase': 'off', // camelcaseについて
    }
};
