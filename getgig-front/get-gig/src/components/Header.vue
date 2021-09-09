<template>
  <header class="main_container" @click="handleClickOutHeader">
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark shadow">
      <div class="container-fluid nav_container">
        <router-link
          to="/"
          class="navbar-brand ms-2"
          @click="handClickOneNavLinks"
          ><img
            class="navbar-logo"
            src="../assets/logo-gris.png"
            alt="logo"
          /><span class="site_name font_1"> GetGig </span></router-link
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse text-center"
          id="navbarSupportedContent"
        >
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 navbar-nav-scroll">
            <li class="nav-item">
              <router-link
                to="/Announcements"
                class="nav-link"
                aria-current="page"
                @click="handClickOneNavLinks"
                >Les annonces</router-link
              >
            </li>
            <li class="nav-item" v-if="this.userConnected">
              <router-link
                to="/MyAnnouncement"
                class="nav-link"
                @click="handClickOneNavLinks"
                >Mes annonces</router-link
              >
            </li>
            <li class="nav-item" v-if="this.userConnected">
              <router-link
                to="/PostAnnouncement"
                class="nav-link"
                @click="handClickOneNavLinks"
                >Poster une annonce</router-link
              >
            </li>
            <li class="nav-item" v-if="this.userConnected">
              <router-link
                to="/Messages"
                class="nav-link"
                @click="handClickOneNavLinks"
                >Mes messages</router-link
              >
            </li>
          </ul>
        </div>
        <!-- ------------------------------ USER CONTAINER ------------------------------ -->
        <div
          class="user_profile-container"
          @mouseover="handleMouseOver"
          @mouseleave="handleMouseleave"
          @click="handleClickOnProfile"
        >
          <div class="user_profile-content user_profile-display">
            <div class="nav-link">
              <div class="user_profile-icon">
                <i class="fas fa-user-alt"></i>
              </div>
              <span v-if="this.userConnected"
                >Hello {{ this.userConnected.user_display_name }}!</span
              >
            </div>
          </div>
          <div class="user_profile-content user_profile-links">
            <router-link
              to="/User"
              class="nav-link"
              @click="handClickOneNavLinks"
            >
              <div class="user_profile-icon">
                <i class="fas fa-user-alt"></i>
              </div>
              <span v-if="this.userConnected"
                >Hello {{ this.userConnected.user_display_name }}!</span
              >
            </router-link>
            <div class="loggin_buttons">
              <div
                class="nav-item"
                style="list-style: none"
                v-if="userDisconnected"
              >
                <router-link
                  to="/Login"
                  class="btn btn-outline-secondary"
                  @click="handClickOneNavLinks"
                  >Connexion</router-link
                >
                <router-link
                  to="/Registration"
                  class="btn btn-outline-secondary"
                  @click="handClickOneNavLinks"
                  >Inscription</router-link
                >
              </div>
              
              <div
                class="nav-item"
                style="list-style: none"
                v-if="userConnected"
              >
              
                <button
                  to="/Login"
                  class="btn btn-outline-secondary"
                  @click="handleClickOnLogoutButton"
                >
                  Deconnexion
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import storage from "../plugins/storage.js";
export default {
  name: "Header",
  props: {
    currentUserLoggedData: Object,
  },
  data() {
    return {
      userConnected: false,
      userDisconnected: true,
      isUserConnected: false,
      profileClicked: false,
    };
  },
  methods: {
    handleClickOnLogoScroll(evt) {
      evt.preventDefault();
      // let screenHomeElement = document.querySelector(".MainHome");
      window.scroll(0, 0);
    },
    handleClickOnProfile(evt) {
      evt.preventDefault();
      if (this.profileClicked === false) {
        this.displayProfileLinks();
        this.profileClicked = true;
      } else {
        this.hydeProfileLinks();
        this.profileClicked = false;
      }
    },
    handleMouseOver(evt) {
      evt.preventDefault();
      if (screen.width > 768) {
        this.displayProfileLinks();
      }
    },
    handleMouseleave(evt) {
      evt.preventDefault();
      this.hydeProfileLinks();
      this.burgerCollapse();
    },
    handClickOneNavLinks(evt) {
      evt.preventDefault();
      this.burgerCollapse();
      window.scroll(0, 0);
    },
    burgerCollapse() {
      let burgerNavElement = document.querySelector("#navbarSupportedContent");
      if (burgerNavElement.classList.contains("show")) {
        burgerNavElement.classList.add("collapsing");
        burgerNavElement.classList.remove("show");
      }
    },
    displayProfileLinks() {
      let profileLinksContainerElement = document.querySelector(
        ".user_profile-links"
      );
      let profileIconElement = document.querySelector(".user_profile-display");
      profileLinksContainerElement.style.display = "flex";
      profileIconElement.style.display = "none";
    },
    hydeProfileLinks() {
      let profileLinksContainerElement = document.querySelector(
        ".user_profile-links"
      );
      let profileIconElement = document.querySelector(".user_profile-display");
      profileLinksContainerElement.style.display = "none";
      profileIconElement.style.display = "flex";
    },
    handleClickOnLogoutButton: function (evt) {
      evt.preventDefault();
      storage.unset("data_from_user");
      this.userConnected = false;
      this.userDisconnected = true;
      this.$router.push("/");
      // burger collapse :
      this.handClickOneNavLinks();
    },
    async checkUserLogged() {
      this.userConnected = await storage.get("data_from_user");
      if (this.userConnected) {
        this.userDisconnected = false;
        this.isUserConnected = true;
      }
    },
    // reload :
    async methodsToReload() {
      this.checkUserLogged();
    },
  },
  async created() {
    this.checkUserLogged();
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
.font_1 {
  font-family: "Fredericka the Great", cursive;
  font-family: 'New Rocker', cursive;
  font-family: 'Mansalva', cursive;
  font-weight: bolder;
  font-size: 1.25rem;
  color: $menuClear;
}
.main_container {
  flex-grow: 1;
  a {
    text-decoration: none;
  }
}

.user_profile-container {
  display: flex;
  flex-direction: column;
  text-align: center;
  .user_profile-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 0.8rem;
    .user_profile-icon {
      font-size: 2rem;
      display: flex;
      justify-content: center;
      color: $various-text;
    }
    span {
      color: $fontColorExtraLight;
    }
  }
  .loggin_buttons {
    padding: 0;
    display: flex;
    flex-direction: column;
  }
  .user_profile-links {
    display: none;
  }
}

//----------NAV BAR-----------------------------------------
.navbar-nav {
  width: 100%;
  justify-content: space-around;
}
.navbar-logo {
  width: 3rem;
}

.navbar {
  max-width: 100vw;
  position: fixed;
  width: 100%;
  top: -0.3rem;
  padding: 1.5rem 0;
  margin: 0;
  z-index: 10;
  background: linear-gradient(rgba(47, 41, 43, 400%), rgba(47, 41, 43, 90%));
}

.site_name {
  @include x-small {
    display: none;
  }
}

.navbar {
  @include x-small {
    padding: 0.5rem 0;
  }
}
</style>