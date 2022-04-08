/* Implementazione delle funzioni di gestione delle transizioni */

function sliderCreator(oggetto,time){
	this.container=oggetto
	this.period=time
	this.indiceSlide=0
	this.clockEvent=null

	/* Implemento la funzione di spostamento , -1/+1 si sposta a sinistra/destra*/
	this.spostaSlide = function(direzione){
		this.nascondiSlide(this.indiceSlide+=direzione);
		this.ruota();
	}

	/* Funzione che si occupa di gestire la rotazione delle slides e di ruotare trascorsa una costante di tempo passata */
	this.ruota=function(){
		if(this.clockEvent!=null){
			clearTimeout(this.clockEvent);
		}
		this.clockEvent= setTimeout("slideshow.spostaSlide(1)",this.period);
	}

	/* Manca solo da nascondere le altre slides tranne quella da mostrare, con elemento intendo la singola slide */
	this.nascondiSlide = function(posizione){
		var elemento= this.container.getElementsByClassName("slides");

		if(posizione >=elemento.length){
			this.indiceSlide=0;
		}
		else if(posizione <0){
			this.indiceSlide=elemento.length-1;
		}
		if(posizione >=elemento.length){
			this.indiceSlide=0;
		}
		for(var i=0;i<elemento.length;i++){
			elemento[i].style.display="none";
		}
		elemento[this.indiceSlide].style.display = "block";
	}
}