<x-layout>

    <div class="dashboard_content ps-0 mt-2">
        <div class="dashboard_content_inner">
            <div class="d-flex justify-content-between mt-1 mb-3">
                <div style="float"class="mt-2">
                    <a href="{{ route('pages.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add new
                        page</a>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('sentence.title') }}</th>
                        <th scope="col">{{ __('sentence.slug') }}</th>
                        <th scope="col" class="text-end">{{ __('sentence.action') }}</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $key=> $page)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$page->title}}</td>
                            <td>{{$page->slug}}</td>
                            <td class="text-end">
                                <a class="btn btn-sm btn-primary" href="{{ route('edit.page', $page) }}"><i
                                    class="fa fa-edit"></i></a>
                                <x-actions.delete :action="route('delete.page', $page)" />
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </div>
</x-layout>
