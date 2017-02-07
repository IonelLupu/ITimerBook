<table class="table">

	<thead>
	<tr>

		<th>#</th>

		@foreach( Autoform::getInputs($model) as $field )

			@if( $field->properties['table']['visible'] )
				<th>{!! $field->label !!} </th>

			@endif
		@endforeach

		<th></th>
	</tr>
	</thead>
	<tbody>

	@foreach( $values as $index => $record )
		<tr class="data-row">
			<td>{{ $index+1 }}</td>

			@foreach( Autoform::getInputs($record) as $field )
				@if( $field->properties['table']['visible'] )
					<td>{!! $field->view() !!} </td>
				@endif
			@endforeach

			<td class="dataTable-actions">

				{{ link_to_route('model.edit', "Edit" ,
                          [ 'model' => $record->getModelName(true),
                            'id' => $record->id ],
                          ["class" => "btn btn-primary"])
                 }}

				{{ link_to_route('model.delete', "Delete" ,
                          [ 'model' => $record->getModelName(true),
                            'id' => $record->id ],
                          ["class" => "btn btn-danger"])
                 }}

			</td>
		</tr>
	@endforeach
	</tbody>
</table>