<template>
  <div>
    <title-bar :title-stack="titleStack"/>
    <hero-bar>
      Профиль
      <router-link slot="right" to="/" class="button">
        На главную
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      <tiles>
        <profile-update-form class="tile is-child"/>
        <card-component title="Профиль" icon="account" class="tile is-child">
          <user-avatar class="image has-max-width is-aligned-center"/>
          <hr>
          <b-field label="Имя">
            <b-input :value="userName" custom-class="is-static" readonly/>
          </b-field>
          <hr>
          <b-field label="E-mail">
            <b-input :value="userEmail" custom-class="is-static" readonly/>
          </b-field>
        </card-component>
      </tiles>
      <password-update-form/>
    </section>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import CardComponent from '@/components/CardComponent'
import TitleBar from '@/components/TitleBar'
import HeroBar from '@/components/HeroBar'
import ProfileUpdateForm from '@/components/ProfileUpdateForm'
import PasswordUpdateForm from '@/components/PasswordUpdateForm'
import Tiles from '@/components/Tiles'
import UserAvatar from '@/components/UserAvatar'
export default {
  name: 'Profile',
  components: { UserAvatar, Tiles, PasswordUpdateForm, ProfileUpdateForm, HeroBar, TitleBar, CardComponent },
  computed: {
    titleStack () {
      return [
        'CallAdmin',
        'Профиль'
      ]
    },
    ...mapState([
      'userName',
      'userEmail'
    ])
  }
}
</script>
