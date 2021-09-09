<template>
  <div class="allAnnouncements container">
    <div class="card mb-3" style="max-width: 1450px">
      <div class="row message_container">
        <img
          class="guitar_smash"
          src="https://i.ibb.co/KXqycZS/gnagnagna.png"
          alt=""
        />
        <p class="">
          Aucune annonce n'a pu être trouvée
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "noAnnouncement",
  props: {
    announcement: Object,
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
.message_container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin: auto;
  p {
    display: flex;
    color: $fontColorDark;
    padding: 4rem 2rem;
    width: auto;
  }
  .guitar_smash {
    display: flex;
    width: 15rem;
    height: auto;
  }
}
.img_announcement {
  max-width: 100%;
}
.card {
  background-color: $fontColorExtraLight;
  border-radius: 1rem;
  box-shadow: 2px 2px 10px grey;
}
</style>