<x-guest-layout>
  <x-auth-card>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <div class="header text-primary-text mb-16 flex flex-col place-content-center place-items-center">
      <div class="title font-montserrat text-primary-text text-[22px] font-bold tracking-wide drop-shadow-xl">Password
        Recovery</div>
      <div class="text font-poppins text-xs">
        Masukkan email untuk mengatur ulang password
      </div>
    </div>

    <form method="POST" class="flex flex-col gap-y-1" action="{{ route('password.email') }}">
      @csrf

      <!-- Email Address -->
      <div class="input-wrapper">
        <label for="email" class="text-primary-text font-montserrat pl-1 text-xs">Email</label>
        <div class="relative z-0 mt-2 flex h-14 w-full flex-col">
          <div
            class="pointer-events-none relative bottom-[6px] z-20 m-auto flex h-full w-full appearance-none place-content-between place-items-center items-center px-4">
            <x-mail />
            <x-xmark />
          </div>
          <input id="email" type="email"
            class="absolute top-[1.5px] z-10 w-full cursor-text rounded-lg border-none py-2 pr-8 pl-12 leading-normal shadow-md outline-none focus:outline-none"
            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
        </div>
      </div>


      <div class="wrapper text-primary-textgray my-6 flex place-content-between place-items-center px-8 text-sm">
        <button type="reset" class="bg-primary-background h-9 w-24 rounded-lg py-2 px-4">Batal</button>
        <button type="submit"
          class="bg-primary-green h-9 w-24 rounded-lg py-2 px-4 font-medium text-white">Kirim</button>
      </div>
    </form>
  </x-auth-card>
</x-guest-layout>
