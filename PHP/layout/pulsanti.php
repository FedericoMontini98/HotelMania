<!-- Sezione relativa alla creazione dei pulsanti necessari a navigare tra le pagine -->

<nav class="_pulsanti">
	<!-- Pulsante pagina precedente -->
	<input type="button" value=" " class="prec" disabled onClick="CaricaLocation.prec('<?php echo $prov?>',getPattern(this))">
	<!-- Mostro la pagina attuale -->
	<div class="N_pagina">Pagina 1</div>
	<!-- Pulsante pagina successiva -->
	<input type="button" value=" " class="succ" disabled onClick="CaricaLocation.succ('<?php echo $prov?>',getPattern(this))">
</nav>