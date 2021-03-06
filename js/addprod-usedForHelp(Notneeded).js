var json = {};
var pricesArray= [];

document.getElementById('btn-addNewAttr').onclick = function(){
  //get the name of the new attribute
  var attr_name = document.getElementById('form-input-attributeName').value;

  //add that name to the json object
  json[attr_name] = [];

  //output all the values
  outputAttrs(json);
};

var getKeys = function(obj){
   var keys = [];
   for(var key in obj){
      keys.push(key);
   }
   return keys;
}

function outputAttrs(obj){
  //function that outputs the attributes and their values
  var output = document.getElementById('attribute-output');

  //wipes clear the current content
  while (output.firstChild) {
    output.removeChild(output.firstChild);
  }

  //for each key value in the json object
  for (var key in obj){
    //create a p element to display its values
    var html = document.createElement("p");
    html.innerHTML = "AttributeName: " + key + ". Values: [";

    for (var i = 0; i < obj[key].length; i++){
      html.innerHTML += " { Value: " + obj[key][i].Value + ", Price: " + obj[key][i].Price + " } ";
    }
    html.innerHTML += "]"

    //create a button that can append the attribute values to
    var button = createButton(key);

    output.appendChild(html);
    output.appendChild(button);
  }

  document.getElementById("json-input").value = JSON.stringify(json);
}

function createButton(key) {
  //function to create the new button, that allows adding in new attr vals
  var button = document.createElement("button");
  var buttonAction = document.createAttribute("type");
  var buttonValue = document.createAttribute("value");
  var buttonId = document.createAttribute("class");
  var buttonFunc = document.createAttribute("onclick");
  buttonFunc.value = "addValue(this.value)";
  buttonId.value = "add-val";
  buttonAction.value = "button";
  button.setAttributeNode(buttonAction);
  button.setAttributeNode(buttonValue);
  button.setAttributeNode(buttonId);
  button.setAttributeNode(buttonFunc);

  button.innerHTML = "Add Attribute Values";
  buttonValue.value = key;

  //returns the created button
  return button;
}

function addValue(clickedVal) {
  //this function should add the current values to the required object property array
  var attr_val = document.getElementById('form-input-attributeValue').value;
  var attr_price = document.getElementById('form-input-attributePrice').value;
  var obj = {"Value":attr_val, "Price":attr_price};

  json[clickedVal].push(obj);

  outputAttrs(json);
}

document.getElementById('btn-addNewShopGrpDisc').onclick = function(){
  var price = document.getElementById('form-input-productPrice').value;
  var group = document.getElementById('form-input-specialShopGroup').value;

  var obj = {"Price":price, "Group":group};

  pricesArray.push(obj);

  outputArray(pricesArray);

  document.getElementById("prod_prices").value = JSON.stringify(pricesArray);
}

function outputArray(array){
  var output = document.getElementById('price-output');
  while (output.firstChild) {
    output.removeChild(output.firstChild);
  }
  for (var i = 0; i < array.length; i++){
    var html = document.createElement('li');
    html.innerHTML = "Price: " + array[i].Price + ", Group: " + array[i].Group;
    output.appendChild(html);
  }

}
