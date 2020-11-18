@extends('layouts.admin')
@section('content')
    @can('slide_show_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.slide-shows.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.slideShow.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.slideShow.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-SlideShow">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.slideShow.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.slideShow.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.slideShow.fields.resource') }}
                        </th>
                        <th>
                            {{ trans('cruds.slideShow.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($slideShows as $key => $slideShow)
                        <tr data-entry-id="{{ $slideShow->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $slideShow->id ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\SlideShow::TYPE_SELECT[$slideShow->type] ?? '' }}
                            </td>
                            <td>
                                @if ($slideShow->type == 'image')
                                    @if($slideShow->image)
                                        <a href="{{ url('local/public/img/slidshow/' . $slideShow->image) }}"
                                           target="_blank">
                                            <img src="{{ url('local/public/img/slidshow/' . $slideShow->image) }}"
                                                 width="50px" height="50px">
                                        </a>
                                    @endif
                                @else
                                    @if($slideShow->video_url)
                                        <a href="{{ $slideShow->video_url }}" target="_blank">
                                            {{$slideShow->video_url}}
                                        </a>
                                    @endif

                                @endif

                            </td>

                            <td>
                                {{ App\Models\SlideShow::STATUS_RADIO[$slideShow->status] ?? '' }}
                            </td>
                            <td>
                                @can('slide_show_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.slide-shows.show', $slideShow->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('slide_show_delete')
                                    <form action="{{ route('admin.slide-shows.destroy', $slideShow->id) }}"
                                          method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
                    @can('slide_show_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.slide-shows.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-SlideShow:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection