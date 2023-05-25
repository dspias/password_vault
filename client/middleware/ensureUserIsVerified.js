export default function ({ store, route, redirect }) {
  const inSetupProfileRoute = route.name === 'step2-setup'
  const inVerifyEmailRoute = route.name === 'step2-verify'
  const inVerifyCompleteRoute = route.name === 'step2-verify-id-hash'

  const shouldVerifyEmail = store.state.auth.loggedIn && !store.state.auth.user.emailVerified
  const shouldSetupProfile = store.state.auth.loggedIn && store.state.auth.user.profile === null

  if (!inSetupProfileRoute && shouldSetupProfile) {
    return redirect('/step2/setup')
  } else if (!shouldSetupProfile && shouldVerifyEmail && !inVerifyEmailRoute && !inVerifyCompleteRoute) {
    return redirect('/step2/verify')
  }
}
