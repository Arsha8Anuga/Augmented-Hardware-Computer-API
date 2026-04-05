<div id="crudModal" class="hidden fixed inset-0 z-50">
    <div
        class="absolute inset-0 bg-[#02070a]/75 backdrop-blur-sm transition-opacity duration-300"
        id="modalBackdrop"
    ></div>

    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div
            class="w-full max-w-lg rounded-[24px] bg-[#0d1a1d]/90 backdrop-blur-[20px] shadow-[0_25px_60px_rgba(0,0,0,0.55)] border border-cyan-400/20 overflow-hidden"
        >
            {{-- Top Accent --}}
            <div class="h-[2px] bg-gradient-to-r from-transparent via-cyan-400/70 to-transparent"></div>

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-cyan-400/10">
                <div>
                    <p class="text-[11px] uppercase tracking-[2px] text-cyan-400/75 mb-1">Editor</p>
                    <h3 id="modalTitle" class="text-xl font-semibold text-white leading-none">Form</h3>
                </div>

                <button
                    id="closeModalBtn"
                    type="button"
                    class="w-10 h-10 rounded-xl border border-white/10 bg-white/5 text-slate-300 text-xl flex items-center justify-center transition-all duration-300 hover:bg-red-500 hover:border-red-500 hover:text-white hover:shadow-[0_0_15px_rgba(255,77,77,0.4)]"
                >
                    &times;
                </button>
            </div>

            {{-- Form --}}
            <form id="crudForm" class="p-6 space-y-5">
                <div id="fieldKeyWrapper">
                    <label class="block text-sm font-medium text-slate-200 mb-2 tracking-wide">Key</label>
                    <input
                        id="fieldKey"
                        type="text"
                        placeholder="Masukkan key..."
                        class="w-full rounded-xl border border-cyan-400/15 bg-white/5 text-slate-100 px-4 py-3 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition-all duration-200"
                    >
                </div>

                <div id="fieldTypeWrapper">
                    <label class="block text-sm font-medium text-slate-200 mb-2 tracking-wide">Type</label>
                    <select
                        id="fieldType"
                        class="w-full rounded-xl border border-cyan-400/15 bg-white/5 text-slate-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition-all duration-200"
                    >
                        <option value="" class="bg-[#0d1a1d] text-slate-300">-- pilih type --</option>
                        <option value="string" class="bg-[#0d1a1d] text-slate-100">string</option>
                        <option value="number" class="bg-[#0d1a1d] text-slate-100">number</option>
                        <option value="object" class="bg-[#0d1a1d] text-slate-100">object</option>
                    </select>
                </div>

                <div id="fieldValueWrapper">
                    <label class="block text-sm font-medium text-slate-200 mb-2 tracking-wide">Value</label>
                    <input
                        id="fieldValue"
                        type="text"
                        placeholder="Masukkan value..."
                        class="w-full rounded-xl border border-cyan-400/15 bg-white/5 text-slate-100 px-4 py-3 placeholder:text-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:border-cyan-400/35 transition-all duration-200"
                    >
                </div>

                <div
                    id="objectWarning"
                    class="hidden rounded-2xl border border-amber-400/20 bg-amber-500/10 px-4 py-3 text-sm text-amber-300"
                >
                    Mengubah ke <span class="font-semibold">object</span> akan menghapus child lama.
                </div>

                {{-- Footer --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                    <button
                        type="button"
                        id="cancelModalBtn"
                        class="px-5 py-3 rounded-xl border border-white/10 bg-white/5 text-slate-200 transition-all duration-300 hover:bg-white/10 hover:border-cyan-400/20 hover:text-white"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="px-5 py-3 rounded-xl bg-cyan-400 text-[#0d1a1d] font-bold shadow-[0_0_20px_rgba(0,188,212,0.25)] transition-all duration-300 hover:bg-cyan-300 hover:shadow-[0_0_28px_rgba(0,188,212,0.45)] hover:-translate-y-0.5 active:translate-y-0"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>