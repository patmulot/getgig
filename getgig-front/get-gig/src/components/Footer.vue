<template>
  <footer class="links_container">
    <ul>
      <li data-page-to-display-name="contact" @click="handleClickOnNavPageLink">
        <router-link to="/Contact">Contact</router-link>
      </li>
      <li data-page-to-display-name="faq" @click="handleClickOnNavPageLink">
        <router-link to="/Faq">FAQ</router-link>
      </li>
      <li data-page-to-display-name="SiteMap" @click="handleClickOnNavPageLink">
        <router-link to="/plan-du-site">Plan du site</router-link>
      </li>
      <li
        data-page-to-display-name="legal-notice"
        @click="handleClickOnNavPageLink"
      >
        <router-link to="/LegalNotice">Mentions légales</router-link>
      </li>
    </ul>
  </footer>
</template>

<script>
export default {
  name: "Footer",
  methods: {
    handleClickOnNavPageLink: function (evt) {
      evt.preventDefault();
      let pageToDisplay = evt.currentTarget.dataset.pageToDisplayName;
      this.showPageToDisplay(pageToDisplay);
    },
    showPageToDisplay: function (pageToDisplay) {
      let allDisplayablePages = document.querySelectorAll(".displayable_pages");

      for (let displayablePage of allDisplayablePages) {
        displayablePage.style.display = "none";

        if (pageToDisplay === displayablePage.dataset.pageName) {
          displayablePage.style.display = "block";
        }
      }
    },
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
ul {
  box-sizing: border-box;
  width: 100%;
  position: relative;
  margin: 0;
  display: flex;
  justify-content: space-around;
  background: linear-gradient(rgba(47, 41, 43, 400%), rgba(47, 41, 43, 90%));
  list-style-type: none;
  padding: 2rem;
  font-size: 0.9rem;
}
.links_container {
  justify-self: flex-end;
}

a {
  text-decoration: none;
  color: #b9b7b0;

}
a:focus{
  color: white;
}
a:hover{
  color: white;
}

</style>