<template>
  <div class="allAnnouncements container">
    <router-link :to="currentUrl" class="single-page nav-link">
      <div class="card mb-3" style="max-width: 1450px">
        <div class="row">
          <div class="col-12 col-md-6 my-auto text-center">
            <img
              :src="imageUrl"
              class="img_announcement img-fluid "
              alt="..."
            />
          </div>
          <div class="col-12 col-md-6">
            <div class="card-body">
              <h4 class="card-title" v-html="title"></h4>
              <h5>Lieu : {{ location }}</h5>
              <p>Du {{ startDate }}</p>
              <p>Au {{ endDate }}</p>
               <p class="card-text" v-html="excerpt"></p>
            <p class="card-text">
              <small class="text-muted">contact via le site</small>
            </p>

            </div>
          </div>
        </div>
      </div>
    </router-link>
  </div>
</template>

<script>

export default {
  name: "allAnnouncements",
  props: {
    announcement: Object,
  },

  async created() {
    
    this.singleAnnouncement = this.announcement;

    this.currentUrl = "/single-announcement/" + this.singleAnnouncement.id; 

    this.title = await this.singleAnnouncement.title.rendered;

    let dateFiltered = new Date(this.singleAnnouncement.date);
    let options = {
      year: "numeric",
      month: "long",
      weekday: "long",
      day: "numeric",
    };
    this.date = dateFiltered.toLocaleDateString("fr-FR", options);

    let startDateFiltered = new Date(this.singleAnnouncement.acf.date_start);
    this.startDate = startDateFiltered.toLocaleDateString("fr-FR", options);

    let endDateFiltered = new Date(this.singleAnnouncement.acf.date_end);
    this.endDate = endDateFiltered.toLocaleDateString("fr-FR", options);

    this.location = await this.singleAnnouncement.acf.location;

    this.content = await this.singleAnnouncement.content.rendered;
    this.excerpt = await this.singleAnnouncement.excerpt.rendered;
    this.id = this.singleAnnouncement.id;

    if (this.singleAnnouncement._embedded["wp:featuredmedia"]) {
      this.singleAnnouncement["imageUrl"] =
        this.singleAnnouncement._embedded["wp:featuredmedia"][0].source_url;
      this.imageUrl = await this.singleAnnouncement._embedded[
        "wp:featuredmedia"
      ][0].source_url;
    }
  },
  data() {
    return {
      allAnnouncements: [],
      isMyAnnouncement: false,
      title: "",
      location: "",
      date: "",
      startDate: "",
      endDate: "",
      content: "",
      excerpt: "",
      imageUrl: "https://i.ibb.co/3mq8TfX/default-image.jpg", 
      currentUrl: "",
      id: 0,
    };
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
.single-page {
  color: $fontColorDark;
  
}
.img_announcement{
  max-width: 100%;
}

.allAnnouncements:hover{
  transform: scale(1.1); 
  
}
.card {
  background-color: $fontColorExtraLight;
  border-radius: 1rem;
  box-shadow: 2px 2px 10px grey;
}
</style>