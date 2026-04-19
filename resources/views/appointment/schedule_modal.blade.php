<!-- Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Agendar cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Quiero agendar una cita</p>

        <p><strong>Fecha seleccionada:</strong> 
            <span id="appointment_date"></span>
        </p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" onClick="enviarWhatsApp()"><i class="fa-brands fa-whatsapp"></i> Enviar mensaje a WhatsApp</button>
      </div>

    </div>
  </div>
</div>