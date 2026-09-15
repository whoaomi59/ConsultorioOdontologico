const express = require("express");
const baileysService = require("./services/BaileysService");
const WhatsappController = require("./controllers/WhatsappController");

const app = express();
app.use(express.json());

baileysService.onMessage(async (msg) => {
  try {
    await WhatsappController.procesarMensaje(baileysService, msg);
  } catch (error) {
    console.error("Error al procesar mensaje:", error);
  }
});

baileysService.iniciar();

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Microservicio escuchando en el puerto ${PORT}`);
});
