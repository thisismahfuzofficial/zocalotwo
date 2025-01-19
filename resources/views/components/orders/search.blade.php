<div class="text-end">
    @if (request()->status ||
            request()->payment_method ||
            request()->restaurant ||
            request()->from_date ||
            request()->to_date ||
            request()->orderSearch ||
            request()->delivery_option)
        <a href="{{ url()->current() }}" class="btn btn-danger RemoveBtn"><i class="fa-solid fa-trash-can"></i></a>
    @endif
    <button class="btn btn-primary" id="offcanvasBtn" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="fa-solid fa-filter"></i>
        Filter</button>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Filtre de recherche de commande</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="" method="GET">
            <div class="row filter-row">
                <div class="col-md-12">
                    <label for="search" class="form-label">Recherche</label>
                    <input type="text" name="orderSearch" class="form-control" placeholder="Recherche ...">
                </div>
                @if (auth()->user()->role_id == 1)

                    <div class="col-md-12 mt-3">
                        <label class="focus-label">Restaurant</label>
                        <select name="restaurant" class="select form-control floating">
                            <option value="">Tous les restaurants</option>
                            @foreach ($restaurantsAll as $key => $restaurant)
                                <option value="{{ $key }}"
                                    {{ request('restaurant') == $key ? 'selected' : '' }}>
                                    {{ $restaurant }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-md-12 mt-3">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="" selected>-- Sélectionnez une option --</option>
                        <option value="PAID">Payé</option>
                        <option value="UNPAID">Non rémunéré</option>
                        <option value="REFUND">Remboursement</option>
                    </select>
                </div>

                <div class="col-md-12 mt-3">
                    <label for="status" class="form-label">Mode de paiement</label>
                    <select name="payment_method" id="status" class="form-control">
                        <option value="" selected>-- Sélectionnez une option --</option>
                        <option value="Card">Carte</option>
                        <option value="Cash on delivery">Paiement à la livraison</option>
                    </select>
                </div>

                <div class="col-md-12 mt-3">
                    <label for="status" class="form-label">Option de livraison</label>
                    <select name="delivery_option" id="status" class="form-control">
                        <option value="" selected>-- Sélectionnez une option --</option>
                        <option value="take_away">Emporter</option>
                        <option value="home_delivery">Livraison à domicile</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label for="form" class="form-label">From</label>
                    <input name="from_date" class="form-control" type="date" value="{{ request()->from_date }}">
                </div>

                <div class="col-md-6 mt-3">
                    <label for="to" class="form-label">To</label>
                    <input name="to_date" class="form-control" type="date" value="{{ request()->to_date }}">
                </div>

                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100">Recherche</button>
                </div>
            </div>
        </form>
    </div>
</div>
