<tr>

	<th>Respuesta:</th><td><textarea class="materialize-textarea" rows="4" name="respuesta" id="respuesta" placeholder="Ingrese su Respuesta" required></textarea></td>

</tr>

<?php if($_SESSION['ticket_tipo'] == 1 || $_SESSION['ticket_tipo'] > 3):?>

	<tr>
		<td>
			
		</td>     
		<td>
			<p>
				<input type="checkbox" name="cierre_parcial" id="cierre_parcial" value="1"/>
				<label for="cierre_parcial">Cierre Parcial</label>
			</p>
        </td>
        <td>
			<p>
				<input type="checkbox" name="informar" id="informar"/>
				<label for="informar">Informar</label>
			</p>
        	
        </td>

	</tr>
	<tr id="campo-asunto">
		<td>
			<strong>Asunto:</strong>
		</td>
		<td>
			<input class="form-control input-sm" id="titulo-informe" name="titulo-informe" type="text">
		</td>
			
	</tr>

	<tr id="campo-select">
		<td>	
			<strong>Personas:</strong>
		</td>
		<td>
		<?php $consulta_listar_usuario = $usuario->listUser($conexion); ?>
			<span id="error-persona">
	            <select class="browser-default" name="persona0" id="persona0" required>
	              	<option value="0">-</option>
					<?php while($resultado_listar_usuario = $consulta_listar_usuario->fetch_array(MYSQLI_ASSOC)): ?>
			                      <option value="<?php echo $resultado_listar_usuario['idUsuario'];?>"><?php echo $resultado_listar_usuario['personaNombre'];?> <?php echo $resultado_listar_usuario['apellido'];?></option>
					<?php endwhile; ?>
		         </select>
	        </span>
	        <td><button type="button" class="btn" id="suma_persona" ><i class="fa fa-plus" aria-hidden="true"></i></button></td>
			<td><button type="button" class="btn" id="borra_persona" ><i class="fa fa-minus" aria-hidden="true"></i></button></td>
			<input type="hidden" name="cantidad_persona" id="cantidad_persona">
		</td>
			
	</tr>

<?php endif;?>

<tr>

	<td> </td>
	<td><button type="submit" class="btn">Enviar</button></td>

</tr>