<template>
  <div class="allAnnouncements">
    <router-link :to="currentUrl" class="single-page nav-link">
      <div class="card mb-3" style="max-width: 1450px">
        <div class="row">
          <div class="col-12 col-md-6 my-auto text-center img_container">
            <img :src="imageUrl" class="img_announcement img-fluid" alt="..." />
            <span class="annoucement-type">
              <i
                class="fas fa-music announcement_tipe-icon"
                v-if="typeArtist"
              ></i>
              <i
                class="fas fa-icons announcement_tipe-icon"
                v-if="typeOrganizer"
              ></i>
            </span>
          </div>
          <div class="col-12 col-md-6">
            <div class="card-body">
              <h4 class="card-title" v-html="title"></h4>
              <h5>Lieu : {{ location }}</h5>
              <p>Du : {{ startDate }}</p>
              <p>Au : {{ endDate }}</p>
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
    this.id = this.singleAnnouncement.id;

    if (this.singleAnnouncement.Type == 3) {
      this.typeOrganizer = "organizer";
    } else if (this.singleAnnouncement.Type == 2) {
      this.typeArtist = "artist";
    }

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
      imageUrl: "https://i.ibb.co/3mq8TfX/default-image.jpg", 
      currentUrl: "",
      id: 0,
      typeOrganizer: false,
      typeArtist: false,
    };
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";
.single-page {
  color: $fontColorDark;
}
.img_announcement {
  max-width: 100%;
}

.allAnnouncements:hover {
  transform: scale(1.1);
}
.card {
  background-color: $fontColorExtraLight;
  // border-radius: 1rem; //! test modif pour images
  box-shadow: 2px 2px 10px grey;
  @include x-small {
    border-bottom-left-radius: 1rem; //! test modif pour images
    border-bottom-right-radius: 1rem; //! test modif pour images
  }
  @include screen-small {
    border-bottom-left-radius: 1rem; //! test modif pour images
    border-bottom-right-radius: 1rem; //! test modif pour images
  }
  @include screen-medium {
    border-bottom-left-radius: 0; //! test modif pour images
    border-top-right-radius: 1rem; //! test modif pour images
    border-bottom-right-radius: 1rem; //! test modif pour images
  }
}
.img_container {
  position: relative;
}
.annoucement-type {
  position: absolute;
  height: 2rem;
  width: 2rem;
  top: 0.5rem;
  right: 1.2rem;
  border-radius: 50%;
  background-color: $fontColorExtraLight;
  box-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
  .announcement_tipe-icon {
    color: $fontColorDark;
    // font-size: 2rem;
    height: 100%;
    width: 100%;
    padding: 0.4rem;
  }
}
</style>