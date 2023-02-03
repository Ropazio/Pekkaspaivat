// Jos on talvi, sivun nimi on Pakkaspäivät (php:lla indexissä ja kirjautumissivulla) ja taustakuva talvinen. Muuta tekstien väri talvikuukausina.
const paivamaara = new Date();
var talvikuukaudet = [0, 1, 2, 10, 11];
var root = document.querySelector(':root');

if (talvikuukaudet.includes(paivamaara.getMonth())) {
	document.body.style.background = "url(img/pakkanen.jpeg)";
	document.body.style.backgroundAttachment = "fixed";
	document.body.style.backgroundSize = "100% auto";

	root.style.setProperty('--green_colour', '#2874a6');
	root.style.setProperty('--darker_green_colour', '#21618c');
}
else {
	pass;
}

