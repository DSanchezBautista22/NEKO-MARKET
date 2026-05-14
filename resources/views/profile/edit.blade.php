<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl sm:text-4xl font-black tracking-tighter uppercase italic">
            <span class="text-white">Per</span><span class="text-[#5865F2]">fil</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-[#36393f] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-[#202225]/95 text-white shadow sm:rounded-lg">
                <div class="max-w-xl flex items-center gap-6">
                    <div class="flex-shrink-0">
                        @if(optional($user)->avatar_path)
                            <img id="avatarPreviewTop" src="{{ asset('storage/' . $user->avatar_path) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-2 border-white/5 shadow-lg">
                        @else
                            <div id="avatarPreviewTop" class="w-20 h-20 rounded-full bg-gradient-to-br from-[#5865F2] to-[#4752C4] flex items-center justify-center text-white font-black text-xl shadow-lg">{{ substr(optional($user)->name ?? 'U', 0, 1) }}</div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data" class="flex w-full sm:w-auto gap-3">
                                @csrf
                                <label class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-[#5865F2] rounded-lg text-white font-bold cursor-pointer text-center">
                                    <input type="file" name="avatar" accept="image/*" class="hidden" id="avatarInputTop" onchange="previewAvatar(event, 'avatarPreviewTop')">
                                    Cambiar avatar
                                </label>
                                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-[#2f3136] text-white rounded-lg border border-white/5">Subir</button>
                            </form>

                            @if(optional($user)->avatar_path)
                                <form action="{{ route('profile.avatar.delete') }}" method="POST" onsubmit="return confirm('¿Eliminar avatar?');" class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-lg">Eliminar avatar</button>
                                </form>
                            @endif

                            @if(session('success'))
                                <div class="text-sm text-green-400 font-bold ms-4">{{ session('success') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-8 bg-[#202225]/95 text-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.mis-productos')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#202225]/95 text-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-[#202225]/95 text-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function previewAvatar(event, previewId) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const el = document.getElementById(previewId);
                if (el.tagName === 'IMG') {
                    el.src = e.target.result;
                } else {
                    el.style.backgroundImage = `url(${e.target.result})`;
                    el.innerHTML = '';
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
