import _ from 'lodash'
import { isFile } from '@/utils/objects'
FormData.prototype.appendRecursive = function (data, wrapper) {
  _.keys(data).forEach((x) => {
    const key = typeof wrapper === 'undefined' ? x : wrapper + '[' + x + ']'

    if (typeof data[x] !== 'object') {
      if (typeof data[x] !== 'undefined') {
        this.append(key, data[x])
      }
    } else if (isFile(data[x])) {
      this.append(key, data[x], data[x].name)
    } else {
      this.appendRecursive(data[x], key)
    }
  })
}
