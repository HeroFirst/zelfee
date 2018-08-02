<script type="text/x-jsrender" id="templateChild">
    <div class="col-xs-4 {{:class}}">
        <div class="form-horizontal">
            <div class="form-group">
                <label for="kids[{{:index}}][gender]" class="col-sm-3 control-label">Пол</label>
                <div class="col-sm-9">
                    <select id="kids[{{:index}}][gender]" name="kids[{{:index}}][gender]" class="form-control" required>
                        <option value="1">Мальчик</option>
                        <option value="2">Девочка</option>
                    </select>
                </div>
            </div>
            <div class="form-group margin-top-30">
                <label for="kids[{{:index}}][first_name]" class="col-sm-3 control-label">Имя</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="kids[{{:index}}][first_name]" name="kids[{{:index}}][first_name]" placeholder="" required>
                </div>
            </div>
            <div class="form-group margin-top-30">
                <label for="kids[{{:index}}][age]" class="col-sm-3 control-label">Возраст</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="kids[{{:index}}][age]" name="kids[{{:index}}][age]" placeholder="" required>
                </div>
            </div>
        </div>
    </div>
</script>