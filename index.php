<html>
<head>
	<title>Painel Itajai</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="cache-control" content="no-cache" />
	<meta http-equiv="pragma" content="no-cache" />
	<!--<meta http-equiv="refresh" content="120">-->
	<meta http-equiv="X-UA-Compatible" content="chrome=1">
	<link rel="stylesheet" href="./assets/css/painel.css">
	<link rel="stylesheet" href="./assets/css/w3.min.css">
	<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="./assets/css/fontawesome.all.min.6.2.1.css">
	<script src="./assets/js/views/fontawesome.all.min.js"></script>
	<script src="./assets/js/views/bootstrap.bundle.min.v5.2.3.js"></script>
	<script src="./assets/js/jquery-3.6.1.min.js"></script>
	<script src="./assets/js/controllers/controllersAux/main.js"></script>
	<script src="./assets/js/axios.min.js"></script>
	<script src="./assets/js/views/vue.global.js"></script>
	<script type="module" src="./assets/js/controllers/painelVue.js"></script>
</head>
<body>
	<div id="app">
		<div class="w3-bar w3-white w3-large ">
			<label class="w3-bar-item w3-button">
				<img class="logo-imagem" src="/scripts/img/logogruporejaile.svg" />
			</label>
			<div class="logo">
				<label class="w3-bar-item w3-button cab w3-right ">RDP Armazenagem - Itajaí</label>
			</div>
		</div>
		<div class="w3-bar w3-teal">
			<label class="w3-bar-item w3-button title fs-4">PAINEL DE CONTROLE</label>
			<label class="w3-bar-item w3-button title w3-right fs-4">{{ currentDate }} {{ currentTime }}</label>
		</div>
		<div class="w3-container w3-black">
			<div class="painel">
				<div id="scroll-container">
					<div id="scroll-text">
						{{ultimoChamado}}
					</div>
				</div>
			</div>
		</div>
		<div class="d-flex justify-content-center mt-1">
			<div v-show="message.length > 0" :style="`background-color: ${cor}`" class=" rounded text-dark fs-6 p-2">
				<h2 :style="`background-color: ${cor}`">{{message}}</h2>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<table class="w3-table w3-table-all">
					<thead>
						<tr>
							<th class="w3-orange">ULTIMOS CHAMADOS</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="chamados in motoristasChamados">
							<td :style="`font-size: ${tamFonteChamados}em`">{{chamados.hora}} - {{chamados.id}} - {{chamados.motorista}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="col">
				<table class="w3-table w3-table-all" id="aguardando">
					<thead>
						<tr>
							<th class="w3-orange">AGUARDANDO</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="aguardo in motoristasAguardando">
							<td :style="`font-size: ${tamFonteAguardando}em`">{{aguardo.hora}} - {{aguardo.id}} - {{aguardo.motorista}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div id="footer" style="position:fixed;top:95%;">
			<input class="w3-input" type="text" name="codigo" id="codigo" placeholder="CODIGO DE BARRAS" autofocus v-model="barcode" @change="onBarcodeScan()">
		</div>
		<table hidden id="minhaTabela">
			<thead>
				<tr>
					<th>ULTIMOS NOMES</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="nomesParaChamar in motoristasNomes">
					<td>{{ nomesParaChamar.motorista }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<script src="https://code.responsivevoice.org/responsivevoice.js?key=dvnPvPwQ"></script>
	<script>
		window.addEventListener('load', function() {
			var inputElement = document.getElementById('codigo')
			inputElement.focus()
		})
	</script>
</body>

</html>