import antfu from '@antfu/eslint-config'
import tailwind from 'eslint-plugin-tailwindcss'
import unusedImports from 'eslint-plugin-unused-imports'
import exports from 'eslint-plugin-import-newlines'

export default antfu({
  ...tailwind.configs['flat/recommended'],
  ...{
    'unused-imports': unusedImports,
    'import-newlines': exports,
    'rules': {
      'no-unused-vars': 'off', // or "@typescript-eslint/no-unused-vars": "off",
      'unused-imports/no-unused-imports': 'error',
      'unused-imports/no-unused-vars': [
        'warn',
        {
          vars: 'all',
          varsIgnorePattern: '^_',
          args: 'after-used',
          argsIgnorePattern: '^_',
        },
      ],
    },
  },
})
