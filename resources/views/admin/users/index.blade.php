@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Manage Users</h2>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">User</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Recipes</th>
                    <th>Joined</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody class="border-top-0">
                @foreach($users as $user)
                <tr>
                    <td class="ps-4 py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-secondary me-3 flex-shrink-0" style="width: 40px; height: 40px; background: url('{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://placehold.co/100x100/A47764/fff?text=' . substr($user->name,0,1) }}') center/cover;"></div>
                            <div>
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="small text-muted">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td>
                        @if($user->status === 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger" title="{{ $user->ban_reason }}">Banned</span>
                        @endif
                    </td>
                    <td>{{ $user->recipes_count }}</td>
                    <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end pe-4">
                        <a href="{{ route('profile.show', $user) }}" class="btn btn-sm btn-outline-secondary rounded-pill me-1" target="_blank">View</a>
                        
                        @if($user->role !== 'admin')
                            @if($user->status === 'active')
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" data-bs-toggle="modal" data-bs-target="#banModal{{ $user->id }}">
                                    Ban
                                </button>
                            @else
                                <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success rounded-pill" onsubmit="return confirm('Unban this user?');">Unban</button>
                                </form>
                            @endif
                        @endif
                    </td>
                </tr>

                @if($user->role !== 'admin' && $user->status === 'active')
                <div class="modal fade" id="banModal{{ $user->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content border-0 rounded-4 shadow">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold text-danger">Ban User: {{ $user->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.users.ban', $user) }}" method="POST">
                                @csrf
                                <div class="modal-body pt-3">
                                    <p class="text-muted">This user will lose access to all authenticated features. This action can be undone later.</p>
                                    <div class="mb-3">
                                        <label for="ban_reason" class="form-label fw-medium">Reason for ban *</label>
                                        <textarea class="form-control" name="ban_reason" rows="3" required placeholder="Spam, inappropriate content, etc."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger rounded-pill px-4">Ban User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-top d-flex justify-content-center">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
