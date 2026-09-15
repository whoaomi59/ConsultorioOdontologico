const db = require("../config/database");

class CitaModel {
  // Verifica si la fecha está reservada manualmente (Ortodoncia)
  static async esFechaExclusivaOrtodoncia(fecha) {
    const [rows] = await db.query(
      "SELECT id FROM fechas_atencion_doctores WHERE fecha = ?",
      [fecha],
    );
    return rows.length > 0;
  }

  // Verifica si el paciente ya tiene una cita activa para ese mismo día
  static async pacienteTieneCitaEnFecha(pacienteId, fecha) {
    const [rows] = await db.query(
      "SELECT id FROM citas WHERE paciente_id = ? AND fecha = ? AND estado != 'cancelada'",
      [pacienteId, fecha],
    );
    return rows.length > 0;
  }

  // 🟢 Nueva validación optimizada ignorando citas canceladas
  static async verificarDisponibilidad(fecha, horaInicio, horaFinal) {
    const [rows] = await db.query(
      `SELECT id FROM citas 
       WHERE fecha = ? 
         AND estado != 'cancelada'
         AND (hora < ? AND hora_final > ?)`,
      [fecha, horaFinal, horaInicio],
    );
    return rows.length === 0;
  }

  static async crear(cita) {
    const { paciente_id, fecha, hora, hora_final, motivo } = cita;
    const [result] = await db.query(
      `INSERT INTO citas (paciente_id, fecha, hora, hora_final, motivo) 
       VALUES (?, ?, ?, ?, ?)`,
      [paciente_id, fecha, hora, hora_final, motivo],
    );
    return result.insertId;
  }

  // Busca citas activas (no canceladas y con fecha mayor o igual a hoy)
  static async buscarCitasActivasPorPaciente(pacienteId) {
    const [rows] = await db.query(
      `SELECT id, fecha, hora, hora_final, motivo 
       FROM citas 
       WHERE paciente_id = ? AND fecha >= CURDATE() AND estado != 'cancelada'
       ORDER BY fecha ASC, hora ASC`,
      [pacienteId],
    );
    return rows;
  }

  // 🟢 Cambia el estado a 'cancelada' en lugar de borrar el registro
  static async cancelarCita(citaId) {
    const [result] = await db.query(
      "UPDATE citas SET estado = 'cancelada' WHERE id = ?",
      [citaId],
    );
    return result.affectedRows > 0;
  }
}

module.exports = CitaModel;
