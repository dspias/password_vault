import { extend } from 'vee-validate'
import { required, alpha, email } from 'vee-validate/dist/rules'

extend('required', {
  ...required,
  message: 'This field is required'
})

extend('email', {
  ...email,
  message: 'The email must be a valid email address'
})

extend('min', {
  validate (value, { length }) {
    return value.length >= length
  },
  params: ['length'],
  message: 'The details must be at least {length} characters.'
})

extend('minval', {
  validate (value, { length }) {
    const number = parseInt(value)
    if (!isNaN(number)) {
      return number >= length
    }
    return false
  },
  params: ['length'],
  message: 'The value must be at least {length}.'
})

extend('minmax', {
  validate (value, { min, max }) {
    return value.length >= min && value.length <= max
  },
  params: ['min', 'max'],
  message: 'This field must be between {min} and {max} characters.'
})

extend('minmaxval', {
  validate (value, { min, max }) {
    const number = parseInt(value)
    if (!isNaN(number)) {
      return number >= min && number <= max
    }
    return false
  },
  params: ['min', 'max'],
  message: 'This field must be between {min} and {max}.'
})

extend('alpha', {
  ...alpha,
  message: 'This field must only contain alphabetic characters'
})
