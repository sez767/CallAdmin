<template>
  <div id="app">
    <nav-bar/>
    <aside-menu :menu="menu"/>
    <transition name="page" mode="out-in">
      <router-view/>
    </transition>
    <!-- <footer-bar/> -->
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from '@/components/NavBar'
import AsideMenu from '@/components/AsideMenu'
import FooterBar from '@/components/FooterBar'

export default {
  name: 'home',
  components: {
    FooterBar,
    AsideMenu,
    NavBar
  },
  computed: {
    menu () {
      return [
        'General',
        [
          {
            to: '/',
            icon: 'desktop-mac',
            label: 'Главная'
          },
          {
            to: '/sites/index',
            label: 'Сайты',
            icon: 'credit-card',
          },
          {
            to: '/staff/index',
            label: 'Персонал',
            icon: 'account-multiple',
          },
          {
            to: '/orders/index',
            label: 'Заявки',
            icon: 'table',
          },
          {
            to: '/calls/index',
            label: 'Звонки',
            icon: 'table',
          },
          {
            to: '/visits/index',
            label: 'Посещения',
            icon: 'table',
          },
          {
            to: '/profile',
            label: 'Мой профиль',
            icon: 'account-circle'
          },
          
        ],
        'Examples',
        [ 
          {
            to: '/clients/index',
            label: 'Clients',
            icon: 'account-multiple',
            // updateMark: true
          },
          {
            to: '/tables',
            label: 'Tables',
            icon: 'table'
          },
          {
            to: '/forms',
            label: 'Forms',
            icon: 'square-edit-outline'
          },
          
          {
            label: 'Submenus',
            subLabel: 'Submenus Example',
            icon: 'view-list',
            menu: [
              {
                href: '#void',
                label: 'Sub-item One'
              },
              {
                href: '#void',
                label: 'Sub-item Two'
              }
            ]
          }
        ],
      ]
    }
  },
  created () {
    axios
      .get('/user')
      .then(r => {
        this.$store.commit('user', r.data.data)
      })
      .catch(err => {
        this.$buefy.toast.open({
          message: `Error: ${err.message}`,
          type: 'is-danger'
        })
      })
  }
}
</script>
<style>
.page-enter-active, .page-leave-active {
  transition: opacity 1s, transform 1s;
}
.page-enter, .page-leave-to {
  opacity: 0;
  transform: translateX(-30%);
}
</style>
