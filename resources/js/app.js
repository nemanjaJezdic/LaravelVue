require('./bootstrap')

import { createApp } from 'vue'
import Welcome from './components/Welcome'
import Formres from './components/Formres'
import AdminView from './components/AdminView'
import AdminIns from './components/AdminIns'
import Adminnews from './components/Adminnews'
import Register from './components/Register'
import Login    from './components/Login'
import Footer from './components/Footer'
import Home from './components/Home'
import ReactionTimer from './components/ReactionTimer'

const app = createApp({})

app.component('welcome', Welcome)
   .component('reactiontimer',ReactionTimer)
   .component('formres', Formres)
   .component('adminview',AdminView)
   .component('adminins',AdminIns)
   .component('adminnews',Adminnews)
   .component('register', Register)
   .component('footerex',Footer)
   .component('login',Login)
   .component('home',Home)

app.mount('#app')
