import Vue from 'vue'

Vue.filter('humanizedDate', val => new Date(val).toDateString())
