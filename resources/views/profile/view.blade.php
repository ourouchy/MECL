<x-app-layout>
    <div x-data="{
            flashMessage: '{{\Illuminate\Support\Facades\Session::get('flash_message')}}',
            init() {
                if (this.flashMessage) {
                    setTimeout(() => this.$dispatch('notify', {message: this.flashMessage}), 200)
                }
            }
        }" class="container mx-auto lg:w-2/3 p-5 mt-16">

        <!-- Page Title -->
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Account</h1>

        <!-- Flash Messages -->
        @if (session('error'))
            <div class="py-3 px-4 bg-red-50 border-l-4 border-red-500 text-red-700 mb-6 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <!-- You can add an SVG icon here if desired -->
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            <!-- Profile Details Section -->
            <div class="bg-white p-6 shadow-md rounded-lg md:col-span-2 border border-gray-100">
                <form x-data="{
                    countries: {{ json_encode($countries) }},
                    billingAddress: {{ json_encode([
                        'address1' => old('billing.address1', $billingAddress->address1),
                        'address2' => old('billing.address2', $billingAddress->address2),
                        'city' => old('billing.city', $billingAddress->city),
                        'state' => old('billing.state', $billingAddress->state),
                        'country_code' => old('billing.country_code', $billingAddress->country_code),
                        'zipcode' => old('billing.zipcode', $billingAddress->zipcode),
                    ]) }},
                    shippingAddress: {{ json_encode([
                        'address1' => old('shipping.address1', $shippingAddress->address1),
                        'address2' => old('shipping.address2', $shippingAddress->address2),
                        'city' => old('shipping.city', $shippingAddress->city),
                        'state' => old('shipping.state', $shippingAddress->state),
                        'country_code' => old('shipping.country_code', $shippingAddress->country_code),
                        'zipcode' => old('shipping.zipcode', $shippingAddress->zipcode),
                    ]) }},
                    get billingCountryStates() {
                        const country = this.countries.find(c => c.code === this.billingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    },
                    sanitizeEmptyFields() {
                        if (this.billingAddress.address2 === '') this.billingAddress.address2 = null;
                        if (this.billingAddress.state === '') this.billingAddress.state = null;
                        if (this.shippingAddress.address2 === '') this.shippingAddress.address2 = null;
                        if (this.shippingAddress.state === '') this.shippingAddress.state = null;
                    },
                    get shippingCountryStates() {
                        const country = this.countries.find(c => c.code === this.shippingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    }
                }" action="{{ route('profile.update') }}" method="post" @submit="sanitizeEmptyFields"
                >
                    @csrf

                    <!-- Personal Information Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                            <span class="inline-block mr-2">
                                <!-- Optional: User icon SVG -->
                            </span>
                            Personal Information
                        </h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <x-input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    value="{{old('first_name', $customer->first_name)}}"
                                    placeholder="First Name"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <x-input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    value="{{old('last_name', $customer->last_name)}}"
                                    placeholder="Last Name"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <x-input
                                type="email"
                                id="email"
                                name="email"
                                value="{{old('email', $user->email)}}"
                                placeholder="Your Email"
                                class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                            />
                        </div>
                        <div class="mb-2">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <x-input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{old('phone', $customer->phone)}}"
                                placeholder="Your Phone"
                                class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                            />
                        </div>
                    </div>

                    <!-- Billing Address Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                            <span class="inline-block mr-2">
                                <!-- Optional: Location icon SVG -->
                            </span>
                            Billing Address
                        </h2>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="billing_address1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                                <x-input
                                    type="text"
                                    id="billing_address1"
                                    name="billing[address1]"
                                    x-model="billingAddress.address1"
                                    placeholder="Street address"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                            <div>
                                <label for="billing_address2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                                <x-input
                                    type="text"
                                    id="billing_address2"
                                    name="billing[address2]"
                                    x-model="billingAddress.address2"
                                    placeholder="Apartment, suite, etc."
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <x-input
                                    type="text"
                                    id="billing_city"
                                    name="billing[city]"
                                    x-model="billingAddress.city"
                                    placeholder="City"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                            <div>
                                <label for="billing_zipcode" class="block text-sm font-medium text-gray-700 mb-1">Postal/Zip Code</label>
                                <x-input
                                    type="text"
                                    id="billing_zipcode"
                                    name="billing[zipcode]"
                                    x-model="billingAddress.zipcode"
                                    placeholder="Postal/Zip Code"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-2">
                            <div>
                                <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <x-input type="select"
                                         id="billing_country"
                                         name="billing[country_code]"
                                         x-model="billingAddress.country_code"
                                         class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Country</option>
                                    <template x-for="country of countries" :key="country.code">
                                        <option :selected="country.code === billingAddress.country_code"
                                                :value="country.code" x-text="country.name"></option>
                                    </template>
                                </x-input>
                            </div>
                            <div>
                                <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                <template x-if="billingCountryStates">
                                    <x-input type="select"
                                             id="billing_state"
                                             name="billing[state]"
                                             x-model="billingAddress.state"
                                             class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm">
                                        <option value="">Select State/Province</option>
                                        <template x-for="[code, state] of Object.entries(billingCountryStates)"
                                                  :key="code">
                                            <option :selected="code === billingAddress.state"
                                                    :value="code" x-text="state"></option>
                                        </template>
                                    </x-input>
                                </template>
                                <template x-if="!billingCountryStates">
                                    <x-input
                                        type="text"
                                        id="billing_state"
                                        name="billing[state]"
                                        x-model="billingAddress.state"
                                        placeholder="State/Province"
                                        class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                    />
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address Section -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-semibold text-gray-700 flex items-center">
                                <span class="inline-block mr-2">
                                    <!-- Optional: Shipping icon SVG -->
                                </span>
                                Shipping Address
                            </h2>
                            <label for="sameAsBillingAddress" class="inline-flex items-center text-gray-700">
                                <input @change="$event.target.checked ? shippingAddress = {...billingAddress} : ''"
                                       id="sameAsBillingAddress" type="checkbox"
                                       class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm">Same as Billing Address</span>
                            </label>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="shipping_address1" class="block text-sm font-medium text-gray-700 mb-1">Address Line 1</label>
                                <x-input
                                    type="text"
                                    id="shipping_address1"
                                    name="shipping[address1]"
                                    x-model="shippingAddress.address1"
                                    placeholder="Street address"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                            <div>
                                <label for="shipping_address2" class="block text-sm font-medium text-gray-700 mb-1">Address Line 2</label>
                                <x-input
                                    type="text"
                                    id="shipping_address2"
                                    name="shipping[address2]"
                                    x-model="shippingAddress.address2"
                                    placeholder="Apartment, suite, etc."
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <x-input
                                    type="text"
                                    id="shipping_city"
                                    name="shipping[city]"
                                    x-model="shippingAddress.city"
                                    placeholder="City"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />
                            </div>
                            <div>
                                <label for="shipping_zipcode" class="block text-sm font-medium text-gray-700 mb-1">Postal/Zip Code</label>
                                <x-input
                                    type="text"
                                    id="shipping_zipcode"
                                    name="shipping[zipcode]"
                                    x-model="shippingAddress.zipcode"
                                    placeholder="Postal/Zip Code"
                                    class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                />

                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <x-input type="select"
                                         id="shipping_country"
                                         name="shipping[country_code]"
                                         x-model="shippingAddress.country_code"
                                         class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm">
                                    <option value="">Select Country</option>
                                    <template x-for="country of countries" :key="country.code">
                                        <option :selected="country.code === shippingAddress.country_code"
                                                :value="country.code" x-text="country.name"></option>
                                    </template>
                                </x-input>
                            </div>
                            <div>
                                <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-1">State/Province</label>
                                <template x-if="shippingCountryStates">
                                    <x-input type="select"
                                             id="shipping_state"
                                             name="shipping[state]"
                                             x-model="shippingAddress.state"
                                             class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm">
                                        <option value="">Select State/Province</option>
                                        <template x-for="[code, state] of Object.entries(shippingCountryStates)"
                                                  :key="code">
                                            <option :selected="code === shippingAddress.state"
                                                    :value="code" x-text="state"></option>
                                        </template>
                                    </x-input>
                                </template>
                                <template x-if="!shippingCountryStates">
                                    <x-input
                                        type="text"
                                        id="shipping_state"
                                        name="shipping[state]"
                                        x-model="shippingAddress.state"
                                        placeholder="State/Province"
                                        class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                                    />
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Update Profile Button -->
                    <div class="flex justify-end">
                        <x-button class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md shadow-sm">
                            Update Profile
                        </x-button>
                    </div>
                </form>
            </div>

            <!-- Password Update Section -->
            <div class="bg-white p-6 shadow-md rounded-lg border border-gray-100">
                <form action="{{route('profile_password.update')}}" method="post">
                    @csrf
                    <h2 class="text-xl font-semibold mb-4 text-gray-700 flex items-center">
                        <span class="inline-block mr-2">
                            <!-- Optional: Lock icon SVG -->
                        </span>
                        Security
                    </h2>
                    <div class="mb-4">
                        <label for="old_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                        <x-input
                            type="password"
                            id="old_password"
                            name="old_password"
                            placeholder="Enter your current password"
                            class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                        />
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <x-input
                            type="password"
                            id="new_password"
                            name="new_password"
                            placeholder="Enter new password"
                            class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                        />
                    </div>
                    <div class="mb-6">
                        <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                        <x-input
                            type="password"
                            id="new_password_confirmation"
                            name="new_password_confirmation"
                            placeholder="Confirm new password"
                            class="w-full focus:border-primary-500 focus:ring-primary-500 border-gray-300 rounded-md shadow-sm"
                        />
                    </div>
                    <div class="flex justify-end">
                        <x-button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-md shadow-sm">
                            Update Password
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
