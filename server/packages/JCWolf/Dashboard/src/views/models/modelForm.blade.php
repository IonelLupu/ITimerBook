<div id="model">


    <form method="POST" action="{{ route( $route['name'], $route['params']) }}">
        {{ csrf_field() }}
        {{ method_field($method) }}

        <input type="text" class="form-control" name="model" placeholder="Model name">


        <table class="table table-hover">

            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                {{--<th>Type</th>--}}
                <th>Properties</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="sortable">

            {{--@foreach($schema as $field => $properties)--}}
            <tr v-for="(field, index) in fieldsNames">
                <td>
                    {{--<input type="hidden" name="fields[]" value="{{ $field }}">--}}
                    <input type="hidden" name="fields[]" v-model="fieldsNames[index]">
                    <span class="handle">
                                <i class="fa fa-ellipsis-v"></i>
                                <i class="fa fa-ellipsis-v"></i>
                            </span>
                </td>
                <td>
                    {{--<input type="text" name="name[]" value="{{ $field }}" class="form-control">--}}
                    <input type="text" name="name[]" v-model="fieldsNames[index]" class="form-control">
                </td>
                {{--<td>--}}
                {{--<select class="form-control select2" name="type[]">--}}
                {{--<option value="" selected disabled>Select type</option>--}}
                {{--@foreach( $inputTypes as $inputName => $inputClass )--}}
                {{--<option value="{{ $inputName }}" @if( $inputName == $properties['type'] ) selected @endif>{{ $inputName }}</option>--}}
                {{--@endforeach--}}
                {{--</select>--}}
                {{--</td>--}}
                <td>
                    {{--                        <textarea name="properties[]" rows="7" style="width: 100%;">{{ json_encode($properties,JSON_PRETTY_PRINT)  }}</textarea>--}}
                    <textarea name="properties[]" rows="7" style="width: 100%;" v-model="fieldsProperties[index]"></textarea>
                </td>
                <td>
                    <span class="btn btn-danger" @click="removeField(index)">
                        <i class="fa fa-trash"></i>
                    </span>
                </td>
            </tr>
            {{--@endforeach--}}
            </tbody>
        </table>

        <div class="row">
            <span class="btn btn-primary" @click="addField">Add Column</span>
            <input class="btn btn-success pull-right" type="submit" value="{{ $button }}">
        </div>
    </form>
</div>

<script>

    var fieldsProperties = Object.values( JSON.parse( '{!! json_encode($schema)  !!} ' ) );
    var fieldsNames      = Object.keys( JSON.parse( '{!! json_encode($schema)  !!} ' ) );

    var app = new Vue( {
        el      : '#model',
        data    : {
            fieldsProperties : fieldsProperties,
            fieldsNames      : fieldsNames,
        },
        methods : {
            addField : function ( ) {

                this.fieldsNames.push( '' );
                this.fieldsProperties.push( { type : "String"} );

            },
            removeField : function ( index ) {

                this.fieldsNames.splice(index,1);
                this.fieldsProperties.splice(index,1);
            }
        }
    } )

</script>