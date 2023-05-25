export const numberFormat = (amount, numOfDigit = 2) => {
  if (!amount) { return (0).toFixed(numOfDigit) }
  return parseFloat(amount).toFixed(numOfDigit)
}

export const dateFormat = (dateString) => {
  return new Date(dateString).toDateString()
}
