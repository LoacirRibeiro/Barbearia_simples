<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbearia Simples</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gold-text { color: #D4AF37; }
        .gold-bg { background-color: #D4AF37; }
    </style>
</head>

<body class="bg-zinc-950 text-zinc-100 font-sans selection:bg-[#D4AF37] selection:text-black">

    <header class="border-b border-zinc-800 bg-zinc-900/50 backdrop-blur sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 h-20 flex items-center justify-between">
            <a href="/" class="text-xl font-black tracking-widest uppercase">
                BARBER<span class="gold-text">SIMPLES</span>
            </a>
            
            <div class="flex items-center space-x-4">
                <nav class="flex space-x-6 text-xs font-bold uppercase tracking-wider text-zinc-400">
                    <a href="#servicos" class="hover:text-zinc-100 transition">Preços</a>
                    <a href="#barbeiros" class="hover:text-zinc-100 transition">Profissionais</a>
                </nav>
                
                {{-- 🔒 Checa se o usuário está logado no site --}}
                @auth
                    {{-- 👑 💰 Se o usuário logado for 'admin' OU 'operador', o botão aparece na Home --}}
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('operador'))
                        <a href="{{ route('admin.caixa') }}" class="bg-[#D4AF37] text-black text-[10px] font-black px-4 py-2 rounded-lg uppercase tracking-widest hover:bg-yellow-500 transition shadow-lg shadow-yellow-500/20">
                            <i class="la la-cog"></i> Painel Administrativo
                        </a>
                    @endif
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-zinc-400 hover:text-zinc-100 transition mr-2">
                        Entrar
                    </a>
                @endguest

                @auth
                    <span class="text-sm text-zinc-400 hidden sm:inline">Olá, <span class="text-[#D4AF37] font-bold">{{ auth()->user()->name }}</span></span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-rose-400 hover:text-rose-300 transition mr-2 cursor-pointer">
                            Sair
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <!-- <div class="w-full pt-20 pb-6 flex items-center justify-center bg-zinc-950">
        <div class="flex flex-col items-center">
            <a href="/" class="block transform hover:scale-102 transition-transform duration-300">
                <img src="{{ asset('images/logo coxxas.png') }}" 
                     alt="BarberCo. Logo" 
                     class="h-56 md:h-72 w-auto object-contain drop-shadow-[0_10px_20px_rgba(212,175,55,0.1)]">
            </a>
            <div class="w-70 h-[1px] bg-zinc-800 mt-6"></div>
        </div>
    </div> -->

    <section class="relative flex items-center justify-center text-center px-4 py-12 bg-radial from-zinc-900 to-zinc-950">
        <div class="max-w-3xl">
            <span class="text-xs font-bold tracking-widest uppercase gold-text block mb-3">Estilo & Tradição</span>
            <h2 class="text-4xl md:text-6xl font-black uppercase tracking-tight mb-6 leading-tight">
                Mais que um corte,<br>uma <span class="gold-text">experiência</span>.
            </h2>
            <p class="text-zinc-400 text-lg md:text-xl max-w-xl mx-auto leading-relaxed">
                Ambiente exclusivo, atendimento personalizado e profissionais qualificados. Atendimento por ordem de chegada.
            </p>
        </div>
    </section>

    <section id="servicos" class="max-w-7xl mx-auto px-4 py-24 border-t border-zinc-900">
        <div class="text-center mb-16">
            <span class="text-xs font-bold tracking-widest uppercase text-[#D4AF37] block mb-2">Tabela de Preços</span>
            <h3 class="text-3xl font-black uppercase tracking-wider">Nossos Serviços</h3>
            <p class="text-zinc-500 mt-2">Cuidado, estilo e confiança para o seu melhor visual!</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach($servicosHome as $categoria => $listaServicos)
                <div class="{{ $categoria === 'Combo' || $categoria === 'Combos' ? 'bg-zinc-900 border-2 border-[#D4AF37]/50 shadow-xl shadow-yellow-500/5 relative overflow-hidden' : 'bg-zinc-900/50 border border-zinc-800' }} p-6 rounded-xl flex flex-col justify-between">
                    
                    @if($categoria === 'Combo' || $categoria === 'Combos')
                        <span class="absolute top-0 right-0 bg-[#D4AF37] text-black text-[9px] font-black uppercase px-3 py-1 tracking-widest rounded-bl">Melhor Custo</span>
                    @endif

                    <div>
                        <h4 class="text-base font-black uppercase tracking-wider text-[#D4AF37] mb-6 pb-2 border-b border-zinc-800">
                            {{ $categoria }}
                        </h4>
                        
                        <ul class="space-y-4">
                            @foreach($listaServicos as $item)
                                <li class="flex flex-col gap-0.5 pb-1 last:border-0">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="{{ $categoria === 'Combo' || $categoria === 'Combos' ? 'text-zinc-100 font-bold' : 'text-zinc-300' }}">
                                            {{ $item->nome }}
                                        </span>
                                        <span class="font-mono font-bold {{ $categoria === 'Combo' || $categoria === 'Combos' ? 'text-[#D4AF37]' : 'text-zinc-100' }}">
                                            R$ {{ number_format($item->preco, 2, ',', '.') }}
                                        </span>
                                    </div>
                                    @if($item->descricao)
                                        <p class="text-[11px] text-zinc-500 mt-0.5">{{ $item->descricao }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="barbeiros" class="bg-zinc-950 py-24 border-t border-zinc-900">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-16">
                <h3 class="text-3xl font-black uppercase tracking-wider">Nossos <span class="gold-text">Especialistas</span></h3>
                <p class="text-zinc-500 mt-2">Escolha o profissional de sua preferência</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse($barbeiros as $barbeiro)
                    <div class="group bg-zinc-900/40 p-4 rounded-2xl border border-zinc-800 text-center flex flex-col items-center hover:border-[#D4AF37]/40 transition-all duration-300 backdrop-blur-sm">
                        
                        <div class="w-full aspect-[4/5] mb-5 relative rounded-xl overflow-hidden border border-zinc-800 group-hover:border-[#D4AF37]/50 transition-all duration-500 bg-zinc-950 flex items-center justify-center shadow-2xl">
                            @if(!empty(trim($barbeiro->foto)))
                                <img src="{{ asset(Str::start(trim($barbeiro->foto), 'storage/')) }}" 
                                     alt="{{ $barbeiro->nome }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center bg-zinc-900 border border-dashed border-zinc-800 m-2 rounded-lg">
                                    <span class="text-[#D4AF37] font-black text-3xl uppercase tracking-widest opacity-60">
                                        {{ substr($barbeiro->nome, 0, 2) }}
                                    </span>
                                    <span class="text-[9px] text-zinc-600 uppercase tracking-wider mt-2">Sem Foto</span>
                                </div>
                            @endif
                        </div>

                        <h4 class="font-bold text-lg text-zinc-200 group-hover:text-white transition-colors mt-2">{{ $barbeiro->nome }}</h4>
                        <span class="inline-block mt-3 px-3 py-1 bg-zinc-950 text-[#D4AF37] border border-zinc-800 text-[10px] font-black tracking-widest uppercase rounded-md">
                            {{ $barbeiro->especialidade ?? 'Barbeiro VIP' }}
                        </span>
                    </div>
                @empty
                    <div class="col-span-full text-center text-zinc-500 py-12 border border-dashed border-zinc-800 rounded-2xl">
                        Nenhum barbeiro cadastrado no painel administrativo ainda.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="border-t border-zinc-900 bg-zinc-950 py-8 text-center text-xs text-zinc-600">
        <p>&copy; 2026 BarberSimples. Todos os direitos reservados.</p>
    </footer>

</body>
</html>