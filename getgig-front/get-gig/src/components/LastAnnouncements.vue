s <template>
  <div class="LastAnnouncements container">
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <div
        class="col"
        v-for="announcement in allAnnouncementsDataTab.slice(0, 4)"
        :key="announcement.id"
      >
        <div class="card">
          <img
            :src="announcement.imageUrl"
            class="card-img-top"
            alt="..."
            @click="handleClickOnOneThumbnail"
            :data-announcement-id="announcement.id"
            :data-announcement-type-id="announcement.typeid"
          />
          <div class="card-body">
            <h5 class="card-title">
              <span v-html="announcement.title"></span>
              <span class="annoucement-type"
                >{{ announcement.typename }}
                <i class="fas fa-music" v-if="announcement.artist"></i>
                <i class="fas fa-icons" v-if="announcement.organizer"></i>
              </span>
            </h5>
            <router-link :to="announcement.url" class="single-page nav-link col-12"
              >Details de l'annonce</router-link
            >
            <h5>Localité : {{ announcement.location }}</h5>
            <p>Publié le : {{ announcement.date }}</p>
            <p>Début le : {{ announcement.date_start }}</p>
     
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import announcementService from "@/services/announcementService.js";
export default {
  name: "LastAnnouncements",
  async created() {
    this.allAnnouncements = await announcementService.loadAnnouncements();
    for (let singleAnnouncement of this.allAnnouncements) {
      let announcementsDataTab = {};
      if (singleAnnouncement._embedded["wp:featuredmedia"]) {
        announcementsDataTab["imageUrl"] =
          singleAnnouncement._embedded["wp:featuredmedia"][0].source_url;
      } else {
        announcementsDataTab["imageUrl"] = "https://i.ibb.co/3mq8TfX/default-image.jpg";
      }
      announcementsDataTab["id"] = singleAnnouncement.id;
      announcementsDataTab["title"] = singleAnnouncement.title.rendered;
      announcementsDataTab["excerpt"] = singleAnnouncement.excerpt.rendered;
      announcementsDataTab["url"] = "/single-announcement/" + singleAnnouncement.id;

      let dateFiltered = new Date(singleAnnouncement.date);
      let options = {
        year: "numeric",
        month: "long",
        weekday: "long",
        day: "numeric",
      };
      this.date = dateFiltered.toLocaleDateString("fr-FR", options);
      announcementsDataTab["date"] = this.date;
      
      let startDateFiltered = new Date(singleAnnouncement.acf.date_start);
      this.startDate = startDateFiltered.toLocaleDateString("fr-FR", options);
      announcementsDataTab["date_start"] = this.startDate;
      
      let endDateFiltered = new Date(singleAnnouncement.acf.date_end);
      this.endDate = endDateFiltered.toLocaleDateString("fr-FR", options);
      announcementsDataTab["date_end"] = this.endDate;
      
      announcementsDataTab["location"] = singleAnnouncement.acf.location;
      if (singleAnnouncement.Type[0]) {
        announcementsDataTab["typeid"] = singleAnnouncement.Type[0];
        if (singleAnnouncement.Type[0] == 2) {
          announcementsDataTab["artist"] = "artist";
          announcementsDataTab["typename"] = "Artiste";
          announcementsDataTab["link"] = "#artist";
        } else if (singleAnnouncement.Type[0] == 3) {
          announcementsDataTab["organizer"] = "organizer";
          announcementsDataTab["typename"] = "Organisateur";
          announcementsDataTab["link"] = "#organizer";
        }
      } else {
        announcementsDataTab["typename"] = "no type";
      }
      this.allAnnouncementsDataTab.push(announcementsDataTab);
    }
  },
  data() {
    return {
      allAnnouncements: [],
      allAnnouncementsDataTab: [],
      currentUrl: "",
    };
  },
  methods: {
    // ---------  DYN DISPLAY HOME ----------------------------
    handleClickOnOneThumbnail(evt) {
      evt.preventDefault();
      let currentAnnouncementClickedId = parseInt(
        evt.currentTarget.dataset.announcementId
      );
      let currentAnnouncementClickedTypeId = parseInt(
        evt.currentTarget.dataset.announcementTypeId
      );
      if (currentAnnouncementClickedTypeId == 2) {
        window.location.href = "#artist";
      } else if (currentAnnouncementClickedTypeId == 3) {
        window.location.href = "#organizer";
      }
      let announcementData = [
        currentAnnouncementClickedId,
        currentAnnouncementClickedTypeId,
      ];
      this.$emit("single-announcement-to-load", announcementData);
    },
    // --------------------------------------------------------------------------
  },
};
</script>

<style scoped lang="scss">
@import "../assets/scss/main.scss";

.card {
  width: 100%;
  height: 100%;
}

.card img {
  width: 100%;
  height:auto;
 
}
.card-title {
  display: flex;
  justify-content: space-between;
  color: $various-text;
  
}
.card-img-top:hover {
  cursor: pointer;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.4);
}
a{
  color: $various-text;
  text-decoration: underline;
  font-size: 1.2rem;;
}
</style>