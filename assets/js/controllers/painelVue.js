import Vue from "./vueJsFramework.js";
const app = new Vue({
  el: "#app",
  data() {
    return {
      menu: "Painel Itajai",
      motoristasAguardando: [],
      motoristasChamados: [],
      motoristasNomes: [],
      barcode: "",
      index: 0,
      tamChamados: "",
      tamAguardando: "",
      currentDate: "",
      currentTime: "",
      tamFonteChamados: 1.5,
      tamFonteAguardando: 1.5,
      message:'',
      ultimoChamado: '',
      cor:'',
 
    };
  },
  filters: {
    upper: function (value) {
      return value.toUpperCase();
    },
    dataFormatada: function (value) {
      return value.split("-").reverse().join("/");
    },
    duasCasasDecimais: function (value) {
      return Number(value).toFixed(2);
    },
  },
  methods: {
    dataAtual() {
      const data = new Date();
      const dia = String(data.getDate()).padStart(2, "0");
      const mes = String(data.getMonth() + 1).padStart(2, "0");
      const ano = data.getFullYear();
      const dataAtual = `${ano}-${mes}-${dia}`;
      return dataAtual;
    },
    onBarcodeScan(event) {
     // this.barcode += event.key;
        console.log(this.barcode); // apenas para testar a saída do valor do código de barras
        this.handleBarcode(this.barcode); // chama a função que lida com o código de barras
        this.barcode = ""; // reseta a propriedade `barcode` para um novo código de barras  
    },
    handleBarcode(barcode) {
      axios
      .post(
        `./controller/PainelController.php?action=findCodigoDeBarras&codigo=${barcode}`
      )
      .then((res) => {

        this.cor = res.data.cor
        this.message = res.data.msg
        
      })
      .catch((err) => {
        console.log(err);
      
      });

      this.selectMotoristasAguardando();
    },
    selectMotoristasAguardando() {
      axios
        .post(
          `./controller/PainelController.php?action=selectMotoristasAguardando`
        )
        .then((res) => {
          this.motoristasAguardando = res.data.row;
          this.tamAguardando = res.data.row.length;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    selectMotoristasChamados() {
      axios
        .post(
          `./controller/PainelController.php?action=selectMotoristasChamados`
        )
        .then((res) => {

          this.ultimoChamado = res.data.row[0]['motorista']
          this.motoristasChamados = res.data.row;
          this.tamChamados = res.data.row.length;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    selectMotoristasNomes() {
      axios
        .post(
          `./controller/PainelController.php?action=selectMotoristasNomes`
          
        )
        .then((res) => {
      
          this.motoristasNomes = res.data.row;

        })
        .catch((err) => {
          console.log(err);
        });
    },
    updateMotoristaChamado(id) {
      axios
        .post(
          `./controller/PainelController.php?action=updateMotoristaChamado&id=${id}`,
          )
        .then((res) => {
            console.log(res)
        })
        .catch((err) => {});
    },
    speakNames() {
      const voice = 'Brazilian Portuguese Male';
      const rate = 0.9;
      const pitch = 1;
     

      this.motoristasNomes.forEach((name) => {

        responsiveVoice.speak(name.motorista + ', por favor, dirija-se a base para carregamento!', voice, { rate, pitch });
    
        this.updateMotoristaChamado(name.id)
      });
    },
    
  },
  watch: {
    motoristasChamados: function(newValue, oldValue){

      this.speakNames()

    },
    tamFonteChamados() {
      if (this.tamChamados > 10) {
        this.tamFonteChamados = 1.0;
      }
      if (this.tamChamados > 15) {
        this.tamFonteChamados = 0.8;
      }
      if (this.tamChamados > 20) {
        this.tamFonteChamados = 0.7;
      }
      if (this.tamChamados > 25) {
        this.tamFonteChamados = 0.5;
      }
      if (this.tamChamados > 30) {
        this.tamFonteChamados = 0.3;
      }
    },
    tamFonteAguardando() {
      if (this.tamAguardando > 10) {
        this.tamFonteAguardando = 1.0;
      }
      if (this.tamAguardando > 15) {
        this.tamFonteAguardando = 0.8;
      }
      if (this.tamAguardando > 20) {
        this.tamFonteAguardando = 0.7;
      }
      if (this.tamAguardando > 25) {
        this.tamFonteAguardando = 0.5;
      }
      if (this.tamAguardando > 30) {
        this.tamFonteAguardando = 0.3;
      }
    },
    index() {
      if (this.index === this.tamChamados) {
        this.index = 0;
      }
    },
    paginaAtual() {
      this.getClientes();
    },
    message() {
      setTimeout(() => {
        this.message = "";
      
      }, 1500);
    },
  },
  mounted: function () {
   
      this.selectMotoristasAguardando();
      this.selectMotoristasChamados();
      this.selectMotoristasNomes();
    setInterval(() => {
      
      this.selectMotoristasAguardando();
      this.selectMotoristasChamados();
      this.selectMotoristasNomes();

    }, 120000);
    setInterval(() => {
      const now = new Date();
      this.currentDate = now.toLocaleDateString();
      this.currentTime = now.toLocaleTimeString();
    }, 1000);
  },
});
