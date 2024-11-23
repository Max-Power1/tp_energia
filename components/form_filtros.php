<div class="d-flex align-items-center justify-content-start m-3">
    <label for="regionSelect" class="me-2">Región:</label>
    <select id="regionSelect" class="form-select form-select-sm me-3" style="width: 150px;">
        <option value="1002">Total SADI</option>
        <option value="418">NEA</option>
        <option value="419">NOA</option>
        <option value="426">GBA</option>
        <option value="422">CENTRO</option>
        <option value="111">PATAGONIA</option>
        <option value="417">LITORAL</option>
        <option value="420">COMAHUE</option>
        <option value="425">PBA</option>
        <option value="429">CUYO</option>
        <!-- Agrega más opciones según las regiones disponibles -->
    </select>

    <div class="form-check form-check-inline me-2">
        <input class="form-check-input" type="radio" name="dataOption" id="demandaOption" value="demanda" checked>
        <label class="form-check-label" for="demandaOption">Demanda</label>
    </div>
    <div class="form-check form-check-inline me-3">
        <input class="form-check-input" type="radio" name="dataOption" id="generacionOption" value="generacion">
        <label class="form-check-label" for="generacionOption">Generación</label>
    </div>
    <div class="ms-auto">
        <button id="printButton" class="btn btn-outline-primary btn-sm me-2">Imprimir</button>
        <button id="exportButton" class="btn btn-outline-success btn-sm">Exportar Datos</button>
    </div>
</div>