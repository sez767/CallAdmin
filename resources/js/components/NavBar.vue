<template>
  <nav v-show="isNavBarVisible" id="navbar-main" class="navbar is-fixed-top">
    <div class="navbar-brand">
      <a class="navbar-item is-hidden-desktop" @click.prevent="menuToggleMobile">
        <b-icon :icon="menuToggleMobileIcon"/>
      </a>
      <div class="navbar-item has-control no-left-space-touch">
      </div>
    </div>
 <b-button v-on:click="showi = !showi" :class="activei == 'true' ? 'redbutton' : ''" id="callB" style="font-size: 16px;" size="is-medium" slot="left"
 v-html="showi ? 'Видеозвонок &#9650;' : 'Видеозвонок &#9660;'" ></b-button>
    <div class="iframeDiv" :class="showi ? '' : 'hide'">
    <iframe
        :src="`https://shop.lendos.biz/videostaff?user=${userId}`"
        width="100%"
        height="100%"
        scrolling="no"
        allowTransparency="true"
        >
    </iframe>
    </div>
   
    <div class="navbar-brand is-right">
      <a class="navbar-item navbar-item-menu-toggle is-hidden-desktop" @click.prevent="menuNavBarToggle">
        <b-icon :icon="menuNavBarToggleIcon" custom-size="default"/>
      </a>
    </div>
    <div class="navbar-menu fadeIn animated faster" :class="{'is-active':isMenuNavBarActive}">
      <div class="navbar-end">

        <nav-bar-menu class="has-divider has-user-avatar">
          <user-avatar/>
          <div class="is-user-name">
            <span>{{ userName }}</span>
          </div>

          <div slot="dropdown" class="navbar-dropdown">
            <router-link
              to="/profile"
              class="navbar-item"
              exact-active-class="is-active"
            >
              <b-icon icon="account" custom-size="default" />
              <span>Мой профиль</span>
            </router-link>
            <a class="navbar-item">
              <b-icon icon="email" custom-size="default"></b-icon>
              <span>Сообщения</span>
            </a>
            <hr class="navbar-divider" />
            <a class="navbar-item"  @click="logout">
              <b-icon icon="logout" custom-size="default"></b-icon>
              <span>Выйти</span>
            </a>
          </div>
        </nav-bar-menu>
 
        <a class="navbar-item is-desktop-icon-only" title="Выйти" @click="logout">
          <b-icon icon="logout" custom-size="default"/>
          <span>Выйти</span>
        </a>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapState } from 'vuex'
import NavBarMenu from '@/components/NavBarMenu'
import UserAvatar from '@/components/UserAvatar'
import Vue from 'vue'
import VueWidgets from 'vue-widgets'
import 'vue-widgets/dist/styles/vue-widgets.css'
Vue.use(VueWidgets)

export default {
  name: 'NavBar',
  components: {
    UserAvatar,
    NavBarMenu
  },
  data () {
    return {
      isMenuNavBarActive: false,
      showi: false,
      activei: false,
    }
  },
  computed: {
    menuNavBarToggleIcon () {
      return this.isMenuNavBarActive ? 'close' : 'dots-vertical'
    },
    menuToggleMobileIcon () {
      return this.isAsideMobileExpanded ? 'backburger' : 'forwardburger'
    },
    ...mapState(['isNavBarVisible', 'isAsideMobileExpanded', 'userName', 'userId'])
  },
  mounted () {
    this.$router.afterEach(() => {
      this.isMenuNavBarActive = false
    }),
    window.addEventListener('message', this.receiveMessage)
  },
  methods: {
    menuToggleMobile () {
      this.$store.commit('asideMobileStateToggle')
    },
    menuNavBarToggle () {
      this.isMenuNavBarActive = !this.isMenuNavBarActive
    },
    logout () {
      document.getElementById('logout-form').submit()
    },
    receiveMessage (event) {
      if (event.data.message) this.activei = event.data.message;
    },
  }
}
</script>
<style scoped>
	iframe {
		position: absolute;
		top: 42px;
		left: -200px;
		width: 100%;
		height: 1300%;
    border-radius: 5px;
    overflow:hidden;
    background: none;
	}
  .iframeDiv{
    width: 60%;
    position: relative;
  }
  #callB{
    margin-top: 5px;
  }
  .hide{
    opacity: 0;
    pointer-events: none; 
  }
  
  .redbutton{
    animation: blinker 1s linear infinite;
  }
  @keyframes blinker {
    0% { background-color: rgb(120, 0, 0); box-shadow: 0 0 3px red; }
    50% { background-color: rgb(220, 0, 0); box-shadow: 0 0 10px red; }
    100% { background-color: rgb(120, 0, 0); box-shadow: 0 0 3px red; }
  }
@media only screen and (max-device-width: 700px) {	
  	.iframeDiv{
      width: 98%;
      position: static;
    }
    iframe{
      left: 0;
    }
 }
	</style>
