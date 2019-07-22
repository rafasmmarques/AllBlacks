<div class="modal fade" id="modalConfirmaExclusao" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-danger" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <p class="heading lead">Aviso</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="text-center">
                    <i class="fa fa-exclamation-triangle fa-4x mb-3 animated rotateIn"></i>
                    <p>Deseja excluir do sistema o torcedor selecionado?</p>
                </div>
            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" onclick="excluiTorcedor()"><i class="fa fa-trash"></i> Excluir</button>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>