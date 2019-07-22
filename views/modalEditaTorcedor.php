<!-- Modal -->
<div class="modal fade" id="modalEditaTorcedor" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Add .modal-dialog-centered to .modal-dialog to vertically center the modal -->
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header elegant-color text-white">
                <h5 class="modal-title">Editar Torcedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#e3ff00;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6">
                        <div class="md-form">
                            <input type="text" class="form-control " id="nome">
                            <label for="nome" class="">Nome:</label>
                        </div>

                        <div class="md-form">
                            <input type="text" class="form-control " id="documento">
                            <label for="documento" class="">Documento:</label>
                        </div>

                        <div class="md-form">
                            <input type="text" class="form-control " id="cep">
                            <label for="cep" class="">CEP:</label>
                        </div>

                        <div class="md-form">
                            <input type="text" class="form-control " id="endereco">
                            <label for="endereco" class="">Endereço:</label>
                        </div>

                        <div class="md-form">
                            <input type="text" class="form-control " id="bairro">
                            <label for="bairro" class="">Bairro:</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="md-form">
                            <input type="text" class="form-control " id="cidade">
                            <label for="cidade" class="">Cidade:</label>
                        </div>

                        <div class="md-form">
                            <input type="text" class="form-control " id="telefone">
                            <label for="telefone" class="">Telefone:</label>
                        </div>

                        <div class="md-form">
                            <input type="text" class="form-control " id="email">
                            <label for="email" class="">E-mail:</label>
                        </div>

                        <input list="uf" name="uf" style="margin-bottom: 2.3rem; margin-top: 1.3rem;">
                        <datalist id="uf">
                            <option id="AC" value="AC">Acre</option>
                            <option id="AL" value="AL">Alagoas</option>
                            <option id="AP" value="AP">Amapá</option>
                            <option id="AM" value="AM">Amazonas</option>
                            <option id="BA" value="BA">Bahia</option>
                            <option id="CE" value="CE">Ceará</option>
                            <option id="DF" value="DF">Distrito Federal</option>
                            <option id="ES" value="ES">Espírito Santo</option>
                            <option id="GO" value="GO">Goiás</option>
                            <option id="MA" value="MA">Maranhão</option>
                            <option id="MT" value="MT">Mato Grosso</option>
                            <option id="MS" value="MS">Mato Grosso do Sul</option>
                            <option id="MG" value="MG">Minas Gerais</option>
                            <option id="PA" value="PA">Pará</option>
                            <option id="PB" value="PB">Paraíba</option>
                            <option id="PR" value="PR">Paraná</option>
                            <option id="PE" value="PE">Pernambuco</option>
                            <option id="PI" value="PI">Piauí</option>
                            <option id="RJ" value="RJ">Rio de Janeiro</option>
                            <option id="RS" value="RS">Rio Grande do Sul</option>
                            <option id="RN" value="RN">Rio Grande do Norte</option>
                            <option id="RO" value="RO">Rondônia</option>
                            <option id="RR" value="RR">Roraima</option>
                            <option id="SC" value="SC">Santa Catarina</option>
                            <option id="SP" value="SP">São Paulo</option>
                            <option id="SE" value="SE">Sergipe</option>
                            <option id="TO" value="TO">Tocantins</option>
                        </datalist>

                        <div class="row">
                            <p class="pl-3 pr-3">Ativo:</p>
                            <div class="form-check">
                                <input class="form-check-input" name="ativo" type="radio" id="ativoSIM" value="SIM">
                                <label class="form-check-label" for="ativoSIM">SIM &nbsp;</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" name="ativo" type="radio" id="ativoNAO" value="NÃO">
                                <label class="form-check-label" for="ativoNAO">NÃO</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" id="btnExcluiTorcedor" onclick="modalConfirmaExclusao()">Excluir</button>
                <button type="button" class="btn btn-sm btn-elegant" id="btnEditaTorcedor" onclick="editaTorcedor(this)">Editar</button>
            </div>
        </div>
    </div>
</div>
