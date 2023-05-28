<template>
  <div>
    <h4 class="mb-2">
      Password Generator
    </h4>
    <hr class="my-2-1">
    <b-row>
      <b-col md="12">
        <div class="w-100 text-center py-2 border">
          <span class="fs-2">{{ result }}</span>
        </div>
        <div class="mt-4">
          <b-form-group v-slot="{ generateTypes }" label="What would you like to generate?">
            <b-form-radio-group
              id="radio-group-1"
              v-model="generateType"
              :options="generateOptions"
              :aria-describedby="generateTypes"
            />
          </b-form-group>
        </div>
        <div v-if="generateType === 'password'">
          <div class="mt-2">
            <b-form-group v-slot="{ passwordTypes }" label="Password type">
              <b-form-radio-group
                id="radio-group-2"
                v-model="passwordType"
                :options="passwordOptions"
                :aria-describedby="passwordTypes"
              />
            </b-form-group>
          </div>
          <div v-if="passwordType === 'password'" class="mt-2">
            <b-row>
              <b-col md="4">
                <div>
                  <label for="passwordLength">Length</label>
                  <b-form-input id="passwordLength" v-model="password.length" type="number" />
                </div>
              </b-col>
              <b-col md="4">
                <div>
                  <label for="minimumNumber">Minimum numbers</label>
                  <b-form-input id="minimumNumber" v-model="password.minNumber" type="number" />
                </div>
              </b-col>
              <b-col md="4">
                <div>
                  <label for="minimumSpacial">Minimum special</label>
                  <b-form-input id="minimumSpacial" v-model="password.minSpacial" type="number" />
                </div>
              </b-col>
              <b-col>
                <b-form-group v-slot="{ ariaDescribedby }" label="Using options array:">
                  <b-form-checkbox-group
                    id="checkbox-group-1"
                    v-model="password.selectedOptions"
                    :options="password.options"
                    :aria-describedby="ariaDescribedby"
                    name="flavour-1"
                  />
                </b-form-group>
              </b-col>
            </b-row>
          </div>
          <div v-if="passwordType === 'passphrase'" class="mt-2">
            <b-row>
              <b-col md="6">
                <div>
                  <label for="number-of-words">Number of words</label>
                  <b-form-input id="number-of-words" v-model="passphrase.words" type="number" />
                </div>
              </b-col>
              <b-col md="6">
                <div>
                  <label for="word-separator">Word separator</label>
                  <b-form-input id="word-separator" v-model="passphrase.separator" type="text" max-length="1" />
                </div>
              </b-col>
              <b-col class="mt-3">
                <b-form-group v-slot="{ ariaDescribedby }" label="Using options array:">
                  <b-form-checkbox-group
                    id="checkbox-group-1"
                    v-model="passphrase.selectedOptions"
                    :options="passphrase.options"
                    :aria-describedby="ariaDescribedby"
                    name="flavour-1"
                  />
                </b-form-group>
              </b-col>
            </b-row>
          </div>
        </div>
        <div v-if="generateType === 'username'" class="mt-2">
          <b-row>
            <b-col class="mt-3">
              <b-form-group v-slot="{ ariaDescribedby }" label="options">
                <b-form-checkbox-group
                  id="checkbox-group-2"
                  v-model="username.selectedOptions"
                  :options="username.options"
                  :aria-describedby="ariaDescribedby"
                />
              </b-form-group>
            </b-col>
          </b-row>
        </div>
      </b-col>
    </b-row>
  </div>
</template>

<script>
import wordList from '@/utils/words'
export default {
  name: 'PasswordGenerator',
  data () {
    return {
      generateType: 'password',
      generateOptions: [
        { text: 'Password', value: 'password' },
        { text: 'Username', value: 'username' }
      ],
      passwordType: 'password',
      passwordOptions: [
        { text: 'Password', value: 'password' },
        { text: 'Passphrase', value: 'passphrase' }
      ],
      password: {
        length: 14,
        minNumber: 1,
        minSpacial: 1,
        selectedOptions: ['A-Z', 'a-z', '0-9', 'ambiguous'],
        options: [
          { text: 'A-Z', value: 'A-Z' },
          { text: 'a-z', value: 'a-z' },
          { text: '0-9', value: '0-9' },
          { text: '!@#$%^&*', value: '!@#$%^&*' },
          { text: 'Avoid ambiguous characters', value: 'ambiguous' }
        ]
      },
      passphrase: {
        words: 3,
        separator: '-',
        selectedOptions: [],
        options: [
          { text: 'Capitalise', value: 'capitalise' },
          { text: 'Include number', value: 'number' }
        ]
      },
      username: {
        selectedOptions: [],
        options: [
          { text: 'Capitalise', value: 'capitalise' },
          { text: 'Include number', value: 'number' }
        ]
      }
    }
  },
  computed: {
    result () {
      if (this.generateType === 'password' && this.passwordType === 'password') {
        return this.generatePassword(this.password)
      } else if (this.generateType === 'password' && this.passwordType === 'passphrase') {
        return this.generatePassphrase(this.passphrase)
      }
      return this.usernameGenerator(this.username)
    }
  },
  methods: {
    generatePassword (passwordConfig) {
      const length = passwordConfig.length
      const minNumber = passwordConfig.minNumber
      const minSpecial = passwordConfig.minSpecial
      const selectedOptions = passwordConfig.selectedOptions

      // Define character sets based on selected options
      const charSets = {
        'A-Z': 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'a-z': 'abcdefghijklmnopqrstuvwxyz',
        '0-9': '0123456789',
        '!@#$%^&*': '!@#$%^&*',
        ambiguous: 'B8G6I1l0OQDS5Z2'
      }

      // Create an array of characters to include in the password
      let includedChars = []
      selectedOptions.forEach((option) => {
        includedChars += charSets[option]
      })

      let password = ''
      let numCount = 0
      let specialCount = 0
      let attempts = 0

      while (password.length < length && (numCount < minNumber || specialCount < minSpecial) && attempts < 1000) {
        password = ''
        numCount = 0
        specialCount = 0

        for (let i = 0; i < length; i++) {
          const randomIndex = Math.floor(Math.random() * includedChars.length)
          const randomChar = includedChars[randomIndex]

          if (/[0-9]/.test(randomChar)) {
            numCount++
          } else if (/[^A-Za-z0-9]/.test(randomChar)) {
            specialCount++
          }

          password += randomChar
        }

        attempts++
      }

      if (password.length < length || numCount < minNumber || specialCount < minSpecial) {
        return '' // Return empty string if the requirements are not met
      }

      return password
    },
    capitalize (str) {
      const lower = str.toLowerCase()
      return str.charAt(0).toUpperCase() + lower.slice(1)
    },
    generatePassphrase (passphrase) {
      const words = []
      // Generate random words
      const dictionary = wordList
      for (let i = 0; i < passphrase.words; i++) {
        const randomIndex = Math.floor(Math.random() * dictionary.length)
        words.push(dictionary[randomIndex])
      }
      // Apply selected options
      if (passphrase.selectedOptions.includes('capitalise')) {
        words.forEach((word, index) => {
          words[index] = this.capitalize(word)
        })
      }
      if (passphrase.selectedOptions.includes('number')) {
        const randomNumber = Math.floor(Math.random() * 100)
        words.push(randomNumber)
      }
      // Join words with the separator
      const passphraseString = words.join(passphrase.separator)
      return passphraseString
    },
    usernameGenerator (options) {
      let username = ''
      // Generate random words
      const randomWords = wordList
      const randomIndex = Math.floor(Math.random() * randomWords.length)
      username = randomWords[randomIndex]
      // Apply selected options
      if (options.selectedOptions.includes('capitalise')) {
        username = this.capitalize(username)
      }
      if (options.selectedOptions.includes('number')) {
        const randomNumber = Math.floor(Math.random() * 100)
        username += randomNumber
      }

      return username
    }
  }
}
</script>
