<template>
  <div class="faq-container">
    <h1 class="display-5 text-center mt-5 mb-5">GetGig FAQ<br/>(foire aux questions)</h1>

    <h2 class="display-6 text-start ms-2">tarifs</h2>
    <p class="paragraphe text-start ms-2 mb-4">
      Les services du site sont proposés à titre gratuit.
    </p>

    <h2 class="display-6 text-start ms-2">horaires</h2>
    <p class="paragraphe text-start ms-2">
      Nous sommes tous des volontaires donc les horaires pour l’administration du site dépendent du temps libre de chacun(e).
    </p>

    <h2 class="display-6 text-start ms-2">temps de réponse</h2>
    <p class="paragraphe text-start ms-2">
      Nous ferons tout notre possible pour vous répondre dans un délai maximum de 48 heures.
    </p>

    <h2 class="display-6 text-start ms-2">modération</h2>
    <p class="paragraphe text-start ms-2">
      Vous pouvez nous informer des éventuelles dérives des contenus en nous contactant via le formulaire de contact, en choisissant le rôle « administrateur » ou nous écrire un email à l’adresse : <br /><br />
      <a href="reclamations-getgig@gmail.com" subject="subject text"> reclamations-getgig@gmail.com</a>
      <br /><br />
      Tout contenu inapproprié signalé ou détecté par nos soins, sera immédiatement supprimé.
      <br /><br />
    </p>

    <h2 class="display-6 text-start ms-2">
      dysfonctionnement du site
    </h2>
    <p class="paragraphe text-start ms-2">
     Vous pouvez nous signaler des éventuelles problèmes techniques en nous contactant via le formulaire de contact, en choisissant le rôle « administrateur » ou nous écrire un email à l’adresse :  <br /><br />
      <a href="reclamations-getgig@gmail.com" subject="subject text"> reclamations-getgig@gmail.com</a>
     </p>

    <h2 class="display-6 text-start ms-2">FAQ à venir</h2>
    <p class="paragraphe text-start ms-2">
      La liste des vos questions est un document vivant, elle  sera complétée au fur et a mesure avec vos futures questions.
    </p>

  </div>
</template>
<script>
export default {
  name: "LegalNotice",
};
</script>

<style lang="scss" scoped>
@import "../assets/scss/main.scss";
// ----------------------------------
// fixes the page height
.main_container {
  flex-grow: 1;
}
// ----------------------------------
.faq-container {
  text-align: center;
  margin-top: 10rem;
}

</style>