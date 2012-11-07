/*
Document : your-voc.js
Created on : 23 avr. 2010
Author : Gannon
Mofify on : 04 oct. 2011
Author : Loïc BIGOT
*/

Array.prototype.indexOf = function(obj){
	var l = this.length;
	for(var i=0; i<l; i++){
		if(this[i] == obj){
			return i;
		}
	}
	return -1;
}
Array.prototype.remove = function(obj){
	var l = this.length;
	var replace = false
	for(var i=0; i<l; i++){
		if(this[i] == obj){
			replace = true;
		}
		if(replace && i<l){
			this[i] = this[i+1];
		}
	}
	if(replace){
		this.pop();
	}
}
Array.prototype.insert = function(p_index, newObj){
	var l = this.length;
	var precObj = null;
	for(var i=0; i<l; i++){
		if(precObj != null){
			var obj = precObj;
			precObj = this[i];
			this[i] = obj;
		}else if(i == p_index){
			precObj = this[i];
			this[i] = newObj;
		}
	}
	if(precObj != null){
		this.push(precObj);
	}else{
		this.push(newObj);
	}
}
function initRevise(){
	initProperties();
	if(formulaire){
		buttonValidError.style.display = 'none';
		document.onkeypress = onPress ;
		//On cache les question sauf le 1er
		indiceReponseListSort = new Array();
		for( var i =0 ; i < divs.length ; i++){
			if(i == 0){
				divs[i].style.display = 'inline';
				divs[i].getElementsByTagName('input')[0].focus();
			}
			indiceReponseListSort.push(i);
		}
		formulaire.indiceReponse = 0 ;
		formulaire.bon = 0 ;
		formulaire.faux = 0 ;
	}
}
function initProperties(){
	window.formulaire = document.getElementById('formulaire');
	window.divs = getElementsByClass('QuestionMot','span');
	window.infoScore = document.getElementById('infoScore');
	window.buttonValidError = document.getElementById('valideError');
	window.buttonSoumettre = document.getElementById('soumettre');
	window.prevReponse = null;
}
function onPress(e){
	e = e || window.event;
	if(e.keyCode == 13) { // Touche entrée
		// On ne valide pas le formulaire
		if(e.preventDefault) {
			e.preventDefault();
		} else {
			e.returnValue = false; // Pour ie
		}
		// Mais Passe a la suite
		nextMots();
		return false ;
	}
}
function nextMots(){
	var blockQuestion = getBlockQuestion(indiceReponseListSort[0]);
	if(!caseSensitive){
		blockQuestion.reponse = blockQuestion.reponse.toLowerCase();
		blockQuestion.solution = blockQuestion.solution.toLowerCase();
	}
	if( blockQuestion.reponse != ""){
		cacheElement(infoScore);
		if(blockQuestion.reponse == blockQuestion.solution){
			cacheElement(buttonValidError);
			formulaire.bon++ ;
			afficheScoreJuste(blockQuestion.question, blockQuestion.solution);
		}else{
			montreElement(buttonValidError);
			formulaire.faux++ ;
			if(modeFullSuccess){
				var indice = 3;
				if(indiceReponseListSort.length < (indice+1)){
					indice = indiceReponseListSort.length - 1;
				}
				indiceReponseListSort.insert(3, blockQuestion.index);
			}
			afficheScoreFaux(blockQuestion.reponse, blockQuestion.question, blockQuestion.solution);
		}
		indiceReponseListSort.shift();
	}
	manageDisplay(blockQuestion.index, indiceReponseListSort[0]);
	prevReponse = blockQuestion;
	if(indiceReponseListSort.length == 0){
		montreElement(buttonSoumettre);
	}
}
function getBlockQuestion(p_index){
	var inpS = divs[p_index].getElementsByTagName('input');
	var blockQuestion = {
		index : p_index,
		block : inpS,
		reponse : inpS[0].value,
		question : inpS[1].value,
		solution : inpS[2].value
	};
	return blockQuestion;
}
function cacheElement(p_elem){
	p_elem.style.display = 'none';
}
function montreElement(p_elem){
	p_elem.style.display = 'inline';
}
function afficheScoreJuste(question, solution){
	infoScore.innerHTML = "<div id=\"revision_juste\"><span style=\"color: White;\">" + question+ " = " + solution + "</span></div>";
	displayNote();
}
function afficheScoreFaux(reponse, question, solution){
	infoScore.innerHTML = "<div id=\"revision_faux\"> <span style=\"color: White;\">''" + reponse + "'' ne veut pas dire ''"+ question +"''. La bonne réponse était: ''" + solution + "''</span></div>" ;
	displayNote();
}
function valideReponseFausse(){
	prevReponse.block[0].value = prevReponse.solution;
	formulaire.faux-- ;
	formulaire.bon++ ;
	if(modeFullSuccess){
		indiceReponseListSort.remove(prevReponse.index);
	}
	cacheElement(buttonValidError);
	afficheScoreJuste(prevReponse.question, prevReponse.solution);
	if(indiceReponseListSort.length == 0){
		montreElement(buttonSoumettre);
	}else{
		var blockQuestion = getBlockQuestion(indiceReponseListSort[0]);
		blockQuestion.block[0].value = "";
		nextMots();
	}
}
function manageDisplay(indiceCache, indiceMontre){
	if(divs[indiceCache]){
		divs[indiceCache].style.display = 'none' ;
	}
	if(divs[indiceMontre]){
		divs[indiceMontre].style.display = 'inline' ;
		divs[indiceMontre].getElementsByTagName('input')[0].focus();
	}
}
function displayNote(){
	var faux = formulaire.faux;
	var pourCent = ((formulaire.bon/(formulaire.bon+faux))*100) ;
	infoScore.innerHTML += "<br/><span style='color: #096A09;'>"
		+ formulaire.bon + " mots justes</span> et <span style='color: #E61700;'>"
		+ (faux) + " mots faux</span>.<br />"
		+ "Moyenne : " + pourCent.toFixed(2) + " %" ;
	montreElement(infoScore);
}
function hasClass(elt,classe){
	var className = elt.className ;
	return className.match(new RegExp("(\\s|^)" + classe + "(\\s|$)"));
}
function getElementsByClass(classe,elementTag) {
	var elemList = document.getElementsByTagName(elementTag);
	var resultats = new Array();
	for(var i=0; i<elemList.length; i++){
		if( hasClass(elemList[i] , classe ) ){
		resultats.push(elemList[i]);
		}
	}
	return resultats;
}
function soumettre(){
	document.formulaire.submit();
}
function validerListe(){
	var listeMots = document.getElementById('newListe').value.split("\n");
	for(var i=0; i<listeMots.length; i++){
		if(listeMots[i].replace(new RegExp("( )*"), "").length==0){
			alert("Merci de ne pas mettre de ligne blanche dans votre liste.");
			return false;
		}else if(!listeMots[i].match("=")){
			alert("Merci de bien mettre un '=' pour chaque mot afin de pouvoir soumettre votre liste. ");
			return false;
		}
	}
	return true;
}

function createElem(defElement){
	var elem = null;
	if(!defElement.tag){
		alert("Pour créer un élément du DOM merci de passer un objet avec la propriété tag");
	}else if(defElement.tag == "text"){
		elem = document.createTextNode(defElement.text);
	}else{	
		elem = document.createElement(defElement.tag);
		for(attr in defElement){
			if(attr != 'tag'){
				elem.setAttribute(attr, defElement[attr]);
			}
		}
	}
	return elem;
}

function removeElem(elem){
	if(elem && elem.parentNode){
		elem.parentNode.removeChild(elem);
	}
}

function createOptionsLangue(selectElem){
	var optionsLang = [
		{label:"Europe", langues:["Allemand","Français","Anglais","Espagnol","Italien","Croate","Danois","Finnois","Grec","Irlandais","Latin","Néerlandais","Norvégien","Portugais","Suédois"]}, 
		{label:"Asie", langues:["Chinois (Cantonnais)","Chinois (Mandarin)","Coréen","Filipino","Indien","Indonésien","Japonais","Mongolien","Thai","Vietnamien"]}, 
		{label:"Slaves", langues:["Russe","Serbe","Polonais","Tcheque"]},
		{label:"Moyen Orient", langues:["Arabe","Hébreu","Turc"]}
	];
	for(var i=0; i<optionsLang.length; i++){
		var defOption = optionsLang[i];
		var optionGroup = createElem({tag:'optgroup', label:defOption.label});
		selectElem.appendChild(optionGroup);
		for(var o=0; o<defOption.langues.length; o++){
			var langue = defOption.langues[o];
			var option = createElem({tag:'option', value:langue});
			option.appendChild(createElem({tag:'text', text:langue}));
			selectElem.appendChild(option);
		}				
	}
	
}

function createListeButtonCharSpec(parentElement){
	var charSpecTab = ['ö','ä','ü','Ä','Ö','Ü','é','è','à','ç','É','È','ô','À','î','ê','Ê'];
	var container = createElem({tag:'div', id:'specialCharContainer'});
	for(var i=0; i<charSpecTab.length; i++){
		var buttonChar = createElem({tag:'input', type:'button', value:charSpecTab[i], name:i+1, onclick:"toucheclavier(this.value);"});
		container.appendChild(buttonChar);
	}
	parentElement.appendChild(container);
}

function createListeSelectLangue(idSelect){
	var selectCateg = $("#" + idSelect)[0];
	var optionTout = createElem({tag:'option', value:"aucun"});
	optionTout.appendChild(createElem({tag:'text', text:"Toutes"}));
	selectCateg.appendChild(optionTout);
	createOptionsLangue(selectCateg);
	selectCateg.options[0].selected = "true";
}