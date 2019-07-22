<!-- Modal -->
<div class="modal fade" id="modalAlertaTorcedor" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header elegant-color text-white">
                <h5 class="modal-title">Enviar Alertas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#e3ff00;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="md-form">
                    <input type="text" class="form-control" id="nomeAlerta">
                    <label for="nomeAlerta" class="">Nome:</label>
                </div>

                <div class="row pl-3 pr-3">
                    <div class="md-form col-6">
                        <input type="text" class="form-control" id="emailAlerta">
                        <label for="emailAlerta" class="">Email:</label>
                    </div>

                    <div class="form-check col-6 pt-2 pl-4">
                        <input type="checkbox" class="form-check-input" id="checkAll">
                        <label class="form-check-label" for="checkAll">Enivar para Todos</label>
                    </div>
                </div>

                <div class="md-form">
                    <input type="text" class="form-control" id="assuntoAlerta">
                    <label for="assuntoAlerta" class="">Assunto:</label>
                </div>

                <div class="md-form">
                    <textarea id="corpoAlerta" class="md-textarea form-control" rows="3">Olá Blacks,

</textarea>
                    <label for="corpoAlerta">Mensagem:</label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-elegant" id="btnEnviaAlerta" onclick="enviaAlerta()">Enviar</button>
            </div>
        </div>
    </div>
</div>
