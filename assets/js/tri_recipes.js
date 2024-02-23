$(document).ready(function () {
  function loadRecipes() {
    const tri = $("#tri").val();
    const url = `tri_recipes.php?tri=${tri}`;
    $.ajax({
      type: "GET",
      url: url,
      dataType: "json",
      success: function (data) {
        $(".grid-container").html("");
        if (data.length === 0) {
          $(".grid-container").html(
            '<div id="noResults" class="alert alert-warning text-center">No recipes found</div>'
          );
        } else {
          for (let dataItem of data) {
            let imageUrl = dataItem.image
              ? `uploads/recipes/${dataItem.image}`
              : "assets/images/recipe_default.jpg";
            let html = `
                  <div class="col-md-2">
                    <div class="card">
                    <a href="./recette.php?id=${dataItem.id}"><img src="${imageUrl}" class="card-img-top" alt="photo ${dataItem.title}"></a>
                      <div class="card-body">
                        <h5 class="card-title">${dataItem.title}</h5>
                        <p class="card-text">${dataItem.description}</p>
                        <a id="recipesCardBtn" href="./recette.php?id=${dataItem.id}" class="btn btn-primary">Voir la recette</a>
                      </div>
                    </div>
                  </div>
                `;

            $(".grid-container").append(html);
          }
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  }
  // Charger les recettes au chargement initial de la page
  loadRecipes();
  // Écouter les changements dans le formulaire de tri
  $("#tri").on("change", function () {
    loadRecipes();
  });
});
