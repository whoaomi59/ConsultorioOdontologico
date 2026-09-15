const {
  makeWASocket,
  useMultiFileAuthState,
  DisconnectReason,
} = require("@whiskeysockets/baileys");
const qrcode = require("qrcode-terminal");

class BaileysService {
  constructor() {
    this.sock = null;
    this.onMessageCallback = null;
  }

  async iniciar() {
    const { state, saveCreds } =
      await useMultiFileAuthState("auth_info_baileys");

    this.sock = makeWASocket({
      auth: state,
      printQRInTerminal: false,
    });

    this.sock.ev.on("creds.update", saveCreds);

    this.sock.ev.on("connection.update", (update) => {
      const { connection, lastDisconnect, qr } = update;
      if (qr) qrcode.generate(qr, { small: true });

      if (connection === "close") {
        const shouldReconnect =
          lastDisconnect?.error?.output?.statusCode !==
          DisconnectReason.loggedOut;
        if (shouldReconnect) this.iniciar();
      }
    });

    this.sock.ev.on("messages.upsert", async (m) => {
      const msg = m.messages[0];
      if (!msg.key.fromMe && m.type === "notify" && this.onMessageCallback) {
        await this.onMessageCallback(msg);
      }
    });
  }

  async enviarTexto(to, text) {
    await this.sock.sendMessage(to, { text });
  }

  onMessage(callback) {
    this.onMessageCallback = callback;
  }
}

module.exports = new BaileysService();
