export default function ({ store, route, redirect }) {
  const inVerifyEmailRoute = route.name === 'step2-verify'
  const inVerifyCompleteRoute = route.name === 'step2-verify-id-hash'

  const shouldVerifyEmail = store.state.auth.loggedIn && !store.state.auth.user.emailVerified

  if (shouldVerifyEmail && !inVerifyEmailRoute && !inVerifyCompleteRoute) {
    return redirect('/step2/verify')
  }
}
