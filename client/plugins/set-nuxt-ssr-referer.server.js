export default function ({ $axios }) {
  $axios.onRequest((config) => {
    // $axios.setHeader('Referer', redirect)
    config.headers['X-Is-SSR-Request'] = 'true'
    config.headers.Referer = config.baseURL

    return config
  })
}
