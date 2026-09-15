const db = require("../config/database");

class PacienteModel {
  // Busca por documento sin necesitar el tipo
  static async buscarPorDocumento(documento) {
    const [rows] = await db.query(
      "SELECT * FROM pacientes WHERE documento = ?",
      [documento],
    );
    return rows.length > 0 ? rows[0] : null;
  }

  static async crear(paciente) {
    const {
      nombre,
      apellido,
      tipo_documento,
      documento,
      genero,
      fecha_nacimiento,
      telefono,
    } = paciente;

    const [result] = await db.query(
      `INSERT INTO pacientes 
       (nombre, apellido, tipo_documento, documento, genero, fecha_nacimiento, telefono) 
       VALUES (?, ?, ?, ?, ?, ?, ?)`,
      [
        nombre,
        apellido,
        tipo_documento,
        documento,
        genero,
        fecha_nacimiento,
        telefono,
      ],
    );

    return result.insertId;
  }
}

module.exports = PacienteModel;
