<div class="modal fade" id="channel-target" aria-hidden="true" aria-labelledby="channel-targetLabel"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="channel-targetLabel">Channels Target</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Channel</th>
                        <th scope="col">Target Achieved</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($channelTargets as $channel => $target)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$channel}}</td>
                            @if(!$target)
                                <td class="text-danger">No</td>
                            @else
                                <td class="text-success">Yes</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal">close</button>
            </div>
        </div>
    </div>
</div>
