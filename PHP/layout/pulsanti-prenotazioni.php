<!-- Sezione relativa alla creazione dei pulsanti necessari a navigare tra le pagine -->
<nav class="_pulsanti">
	<!-- Pulsante pagina precedente -->
	<input type="button" value=" " class="prec" disabled onClick="CaricaLocation.precPren('<?php echo $prov?>',getPattern(this),<?php echo $_SESSION["HotelManiaIDUtente"]?>)">
	<!-- Mostro la pagina attuale -->
	<div class="N_pagina">Pagina 1</div>
	<!-- Pulsante pagina successiva -->
	<input type="button" value=" " class="succ" disabled onClick="CaricaLocation.succPren('<?php echo $prov?>',getPattern(this),<?php echo $_SESSION["HotelManiaIDUtente"]?>)">
</nav>