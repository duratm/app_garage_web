var xhr = new XMLHttpRequest();
xhr.open("GET", "retrieve.php", false);
xhr.send(null);

var models = JSON.parse(xhr.responseText);

function deleteAllOptions() {
    var model = document.getElementById('listModel');
    var child = model.lastElementChild;
    while (child) {
        model.removeChild(child);
        child = model.lastElementChild;
    }
}

function putModel(){
    var brandSelected = document.getElementById('listBrand');
    var value = brandSelected.value;
    deleteAllOptions();
    let modelForBrand = getModelFromBrand(parseInt(value));
    toSelect(modelForBrand);
}

function toSelect(modelForBrand) {
    var model = document.getElementById('listModel');
    var firstOption = document.createElement('option');
    firstOption.value = 0;
    firstOption.textContent = 'Choisir le modèle';
    model.appendChild(firstOption);
    for (var step = 0; step < modelForBrand.length; step++){
        var option = document.createElement('option');
        option.value = modelForBrand[step].nummodel;
        option.textContent = modelForBrand[step].libelle;
        model.appendChild(option);
    }
}

function getModelFromBrand(brand){
    var modelForBrand = new Array();
    for (var step = 0; step<models.length; step++) {
        if (models[step].numbrand === brand){
            modelForBrand.push(models[step]);
        }
    }
    return modelForBrand;
}

