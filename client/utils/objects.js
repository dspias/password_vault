export function isFile (object) {
  return object && (object.constructor.name === 'File' || object.constructor.name === 'FileList')
}
