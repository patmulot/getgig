<template>
  <div class="site-map main-container container">
      <h1>Plan du site</h1>

      <img class="col-10 arbo" src="../assets/images/arbo/Arborescence.png" alt="arborescence_getgig">
    
  </div>
</template>
<script>
export default {
  name: "SiteMap",
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";

// fixes the page height
.main_container {
  flex-grow: 1;
}

.legal-notice {
  text-align: center;
  margin-top: 10rem;
}
.arbo{
    width: 100%;
}

.arbo:hover {
  transform: scale(2); 
}
.site-map{
    margin-top: 10rem;
    margin-bottom: 20vh;
}
</style>