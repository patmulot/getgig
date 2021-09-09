<template>
  <div class="main_container">
    <div class="search_announcement text-center">
      <h1>Les Annonces</h1>
      <div class="col-10 mx-auto pb-5">
        <div class="type-announcement row mx-auto col-10 col-md-8 col-lg-8">
          <span class="sorting_choices" v-if="isSortedBy"
            >Tri par :
            <span v-if="isSortedOne" class="sorted_by sorted_by-type">{{
              isSortedOne
            }}</span>
            <span v-if="sortedSeparationOne"> / </span>
            <span v-if="isSortedTwo" class="sorted_by sorted_by-location"
              >{{ isSortedTwo }}
            </span>
            <span v-if="sortedSeparationTwo"> / </span>
            <span v-if="isSortedThree" class="sorted_by sorted_by-date">
              {{ isSortedThree }}</span
            >
            <span class="sorting_reset" @click="handleClickOneResetSorting">
              réinitialiser le tri</span
            >
          </span>

          <label class="ms-1 mt-4 fs-5" for="type-announcement"
            >Type d'annonce :
            <span class="sorting_error_message" v-if="sortingByTypeMessage"
              >Vous avez déjà un tri par type en cours</span
            ></label
          >
          <select
            name="type-announcement"
            id="type-announcement"
            class="register_form-role_selector col-12 register_form-input"
            @change="selectUserRole"
          >
            <option
              value="0"
              selected
              class="register_form-role_selector-option"
            >
              -- Selectionner un type d'annonce --
            </option>
            <option value="2" class="register_form-role_selector-option">
              Artiste
            </option>

            <option value="3" class="register_form-role_selector-option">
              Organisateur d'évènements
            </option>
          </select>
        </div>
        <div class="town row mx-auto col-10 col-md-8 col-lg-8">
          <label class="ms-1 mt-4 fs-5" for="town"
            >Localité :
            <!-- <em class="selected_location_preview" v-if="selectedCity">{{
              selectedCity
            }}</em> -->
            <span class="sorting_error_message" v-if="sortingByLocationMessage"
              >Vous avez déjà un tri par localité en cours :
            </span></label
          >
          <label v-if="isLocationSearch" class="ms-1 mt-4 fs-5" for="town"
            ><span v-if="isLocationSearchMessage"
              >ville en cours de recherche...</span
            ></label
          >
          <div class="location_input-container">
            <input
              type="text"
              name="town"
              class="location-input"
              placeholder="Nom de la ville"
              v-model="userLocationFromForm"
            />
            <button class="location-icon" @click="handleClickOnLoadCityButton">
              <i class="fas fa-search-location"></i>
            </button>
          </div>
          <div
            class="select_location-button-container"
            v-for="oneCityData in cityDatas"
            :key="oneCityData.id"
          >
            <button
              class="one_city_button"
              :value="oneCityData.label"
              @click="handleClickOnCity"
              :data-city-name="oneCityData.city"
            >
              <span class="one_city-select"
                >{{ oneCityData.label }} <i class="fas fa-caret-right"></i
              ></span>
            </button>
          </div>
        </div>
        <div class="datetime mx-auto text-start col-10 col-md-8 col-lg-8">
          <label class="ms-1 mt-4 fs-5" for="start-date"
            >Date :
            <span class="sorting_error_message" v-if="sortingByDateMessage"
              >Vous avez déjà un tri par Date en cours</span
            ></label
          >
          <input
            type="date"
            name="date"
            class="col-12 announcement_form announcement_form-input date_input"
            @change="selectDate"
          />
        </div>
      </div>
    </div>

    <div class="all_announcements">
      <noAnnouncement v-if="noAnnouncementFound" />
    </div>
    <div
      class="all_announcements"
      v-for="announcement in allAnnouncementsTab"
      :key="announcement.id"
    >
      <allAnnouncements :announcement="announcement" />
    </div>
  </div>
</template>

<script>
import allAnnouncements from "../components/allAnnouncements.vue";
import locationService from "../services/locationService.js";
import announcementService from "../services/announcementService.js";
import noAnnouncement from "../components/noAnnouncement.vue";

export default {
  name: "Announcements",
  components: {
    allAnnouncements,
    noAnnouncement,
  },
  data() {
    return {
      locationsResponse: [],
      cityDatas: [],
      selectedCity: "",
      allAnnouncementsTab: [],
      userRoleFromForm: 0,
      dateTimeSelected: "",
      userLocationFromForm: "",
      isLocationSearch: false,
      isLocationSearchMessage: false,
      noAnnouncementFound: false,
      isSortedBy: false,
      isSortedByType: false,
      isSortedByLocation: false,
      isSortedByDate: false,
      sortedIndex: 0,
      sortedSeparationOne: false,
      sortedSeparationTwo: false,
      isSortedOne: false,
      isSortedTwo: false,
      isSortedThree: false,
      currentTypeSelected: "",
      announcementTypeTempArray: [],
      announcementLocationTempArray: [],
      announcementDateTempArray: [],
      sortingByTypeMessage: false,
      sortingByLocationMessage: false,
      sortingByDateMessage: false,
    };
  },
  async created() {
    this.allAnnouncementsTab = await announcementService.loadAnnouncements();
  },
  methods: {
    async handleClickOneResetSorting(evt) {
      this.noAnnouncementFound = false;
      evt.preventDefault();
      this.isSortedBy = false;
      this.isSortedByType = false;
      this.userLocationFromForm = "";
      this.isSortedByLocation = false;
      this.isSortedByDate = false;
      this.sortedIndex = 0;
      this.isSortedBy = false;
      this.sortedSeparationOne = false;
      this.sortedSeparationTwo = false;
      this.isSortedOne = false;
      this.isSortedTwo = false;
      this.isSortedThree = false;
      this.currentTypeSelected = 0;
      this.selectedCity = "";
      this.dateTimeSelected = "";
      this.sortingByTypeMessage = false;
      this.sortingByLocationMessage = false;
      this.sortingByDateMessage = false;
      let optionsElements = document.querySelectorAll(
        ".register_form-role_selector-option"
      );
      for (let oneOption of optionsElements) {
        oneOption.selected = oneOption.defaultSelected;
      }
      let locationInputElement = document.querySelector(".location-input");
      locationInputElement.value = "";
      let dateInputElement = document.querySelector(".date_input");
      dateInputElement.value = "";
      this.allAnnouncementsTab = await announcementService.loadAnnouncements();
      // this.created();
      this.$router.go();
    },
    async selectUserRole(evt) {
      this.isSortedBy = true; //!
      evt.preventDefault();
      this.noAnnouncementFound = false;
      this.userRoleFromForm = parseInt(evt.currentTarget.value);
      if (parseInt(this.userRoleFromForm) == 2) {
        this.currentTypeSelected = "artiste";
      } else if (parseInt(this.userRoleFromForm) == 3) {
        this.currentTypeSelected = "organisateur";
      }
      if (this.isSortedByLocation === false && this.isSortedByDate === false) {
        const allAnnouncementsByType =
          await announcementService.loadAnnouncementsByType(
            this.userRoleFromForm
          );
        this.allAnnouncementsTab = allAnnouncementsByType;
        this.isSortedOne = this.currentTypeSelected;
        this.isSortedByType = true;
        this.sortedIndex = 1;
        if (this.allAnnouncementsTab.length == 0) {
          this.noAnnouncementFound = true;
        }
      } else {
        if (this.isSortedByType === false) {
          for (let oneAnnouncement of this.allAnnouncementsTab) {
            if (oneAnnouncement.Type == this.userRoleFromForm) {
              this.announcementTypeTempArray.push(oneAnnouncement);
            }
          }
          this.allAnnouncementsTab = this.announcementTypeTempArray;
          if (this.sortedIndex === 0) {
            this.isSortedOne = this.currentTypeSelected;
          } else if (this.sortedIndex === 1) {
            this.sortedSeparationOne = true;
            this.isSortedTwo = this.currentTypeSelected;
          } else if (this.sortedIndex === 2) {
            this.sortedSeparationTwo = true;
            this.isSortedThree = this.currentTypeSelected;
          }
          if (this.sortedIndex === 2) {
            this.sortedIndex = 2;
          } else {
            this.sortedIndex++;
          }
          this.isSortedByType = true;
        } else {
          this.allAnnouncementsTab = [];
          this.sortingByTypeMessage = true;
          this.noAnnouncementFound = true;
        }
      }
      if (this.allAnnouncementsTab.length == 0) {
        this.noAnnouncementFound = true;
      }
    },
    async handleClickOnLoadCityButton(evt) {
      evt.preventDefault();
      this.cityDatas = [];
      this.isLocationSearch = true;
      this.isLocationSearchMessage = true;
      const results = await locationService.loadLocation(
        this.userLocationFromForm
      );
      if (results) {
        this.isLocationSearch = false;
        this.isLocationSearchMessage = false;
      }
      this.locationsResponse = await results;
      for (let oneLocation in this.locationsResponse) {
        this.cityDatas.push(this.locationsResponse[oneLocation].properties);
      }
    },
    async handleClickOnCity(evt) {
      evt.preventDefault();
      this.isSortedBy = true; //!
      this.noAnnouncementFound = false;
      this.selectedCity = evt.currentTarget.dataset.cityName;
      let allButtonsToHyde = evt.currentTarget
        .closest(".town")
        .querySelectorAll(".select_location-button-container");
      for (let oneButtonToHyde of allButtonsToHyde) {
        oneButtonToHyde.style.display = "none";
      }
      if (this.isSortedByType === false && this.isSortedByDate === false) {
        this.allAnnouncementsTab =
          await announcementService.loadAnnouncements();
        this.announcementLocationTempArray = [];
        for (let oneAnnouncement of this.allAnnouncementsTab) {
          if (oneAnnouncement.acf.location == this.selectedCity) {
            this.announcementLocationTempArray.push(oneAnnouncement);
          }
        }
        this.allAnnouncementsTab = this.announcementLocationTempArray;
        this.isSortedOne = this.selectedCity;
        this.isSortedByLocation = true;
        this.sortedIndex = 1;
        if (this.allAnnouncementsTab.length == 0) {
          this.noAnnouncementFound = true;
        }
      } else {
        if (this.isSortedByLocation === false) {
          if (this.sortedIndex === 0) {
            this.isSortedOne = this.selectedCity;
          } else if (this.sortedIndex === 1) {
            this.sortedSeparationOne = true;
            this.isSortedTwo = this.selectedCity;
          } else if (this.sortedIndex === 2) {
            this.sortedSeparationTwo = true;
            this.isSortedThree = this.selectedCity;
          }
          if (this.sortedIndex === 2) {
            this.sortedIndex = 2;
          } else {
            this.sortedIndex++;
          }

          for (let oneAnnouncement of this.allAnnouncementsTab) {
            if (oneAnnouncement.acf.location == this.selectedCity) {
              this.announcementLocationTempArray.push(oneAnnouncement);
            }
          }
          this.allAnnouncementsTab = this.announcementLocationTempArray;
          this.isSortedByLocation = true;
        } else {
          this.allAnnouncementsTab = [];
          this.sortingByLocationMessage = true;
          this.noAnnouncementFound = true;
        }
        if (this.allAnnouncementsTab.length == 0) {
          this.noAnnouncementFound = true;
        }
      }
    },
    async selectDate(evt) {
      this.selectedCity = "";
      evt.preventDefault();
      this.noAnnouncementFound = false;
      this.isSortedBy = true; //!
      this.dateTimeSelected = evt.currentTarget.value;
      if (this.isSortedByLocation === false && this.isSortedByType === false) {
        this.allAnnouncementsTab =
          await announcementService.loadAnnouncements();
        this.announcementDateTempArray = [];
        for (let oneAnnouncement of this.allAnnouncementsTab) {
          if (this.dateTimeSelected == oneAnnouncement.acf.date_start) {
            this.announcementDateTempArray.push(oneAnnouncement);
          }
          this.allAnnouncementsTab = this.announcementDateTempArray;
        }
        this.allAnnouncementsTab = this.announcementDateTempArray;
        this.isSortedOne = this.dateTimeSelected;
        this.isSortedByDate = true;
        this.sortedIndex = 1;
        if (this.allAnnouncementsTab.length == 0) {
          this.noAnnouncementFound = true;
        }
      } else {
        if (this.isSortedByDate === false) {
          if (this.sortedIndex === 0) {
            this.isSortedOne = this.dateTimeSelected;
          } else if (this.sortedIndex === 1) {
            this.sortedSeparationOne = true;
            this.isSortedTwo = this.dateTimeSelected;
          } else if (this.sortedIndex === 2) {
            this.sortedSeparationTwo = true;
            this.isSortedThree = this.dateTimeSelected;
          }
          if (this.sortedIndex === 2) {
            this.sortedIndex = 2;
          } else {
            this.sortedIndex++;
          }
          this.isSortedByDate = true;
          for (let oneAnnouncement of this.allAnnouncementsTab) {
            if (oneAnnouncement.acf.date_start == this.dateTimeSelected) {
              this.announcementDateTempArray.push(oneAnnouncement);
            }
          }
          this.allAnnouncementsTab = this.announcementDateTempArray;
        } else {
          this.allAnnouncementsTab = [];
          this.sortingByDateMessage = true;
          this.noAnnouncementFound = true;
        }
        if (this.allAnnouncementsTab.length == 0) {
          this.noAnnouncementFound = true;
        }
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
.main_container {
  flex-grow: 1;
  margin-top: 8rem;
  color: $fontColorExtraLight;
}
h1 {
  color: $fontColorExtraLight;
  margin-top: 2rem;
}
.search_announcement {
  background-color: $fontColorMediumLight;
  margin-bottom: 1rem;
  border-radius: 2rem;
  padding-top: 2rem;
  margin: 2rem;
  @include screen-large {
    position: fixed;
    top: 14vh;
    width: 40%;
    margin-left: 10%;
    padding: 2rem;
    height: cover;
  }
}
// ----------------------------------
.location_input-container {
  width: 100%;
  display: flex;
  padding: 0;
  .location-input {
    width: 100%;
  }
}
.one_city_button {
  width: 100%;
  margin-top: 0.5rem;
  background-color: #6d3844;
  color: #f7f6f6;
  .one_city-select {
    display: flex;
    justify-content: space-between;
    padding: 0.2rem;
  }
}
.selected_location_preview {
  color: #6d3844;
  font-weight: bold;
}
// ----------------------------------

.all_announcements {
  margin: auto;
  width: 100%;
}
.all_announcements {
  @include screen-large {
    margin: 0;
    position: relative;
    width: 40%;
    left: 55%;
  }
}
label {
  padding-top: 1.5rem;
  color: $fontColorExtraLight;
  text-align: start;
}
input {
  padding: 0.5rem;
  border-bottom-right-radius: 14px 14px;
}
button {
  padding: 0.5rem;
  border-radius: 0.5rem;
  color: $fontColorExtraLight;
  background-color: $various-menus;
  margin-top: 0.5rem;
}
// .sorted_by {
//   font-weight: bold;
// }
// .sorted_by:hover {
//   font-weight: bold;
//   color: $various-text;
//   cursor: pointer;
// }
.sorting_error_message {
  color: $various-text;
}
.sorting_reset {
  font-weight: bold;
  color: $various-text;
  // text-decoration: underline;
}
.sorting_reset:hover {
  font-weight: bold;
  color: $fontColorExtraLight;
  cursor: pointer;
}
// ----------------------------------
</style>