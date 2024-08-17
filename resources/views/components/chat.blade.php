<div class="container py-5">
  <div class="row">
      <div class="col-md-12">
          <div class="card" id="chat3" style="border-radius: 15px;">
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                          <div class="p-3">
                              <div class="input-group rounded mb-3">
                                  <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                                  <span class="input-group-text border-0" id="search-addon">
                                      <i class="fas fa-search"></i>
                                  </span>
                              </div>

                              <div data-mdb-perfect-scrollbar-init style="position: relative; height: 400px">
                                  <ul class="list-unstyled mb-0">
                                      @foreach ($users as $user)
                                          <li class="p-2 border-bottom">
                                              <a href="#!" class="d-flex justify-content-between">
                                                  <div class="d-flex flex-row">
                                                      <div>
                                                          <img src="{{ $user['avatar'] }}" alt="avatar" class="d-flex align-self-center me-3" width="60">
                                                          <span class="badge bg-success badge-dot"></span>
                                                      </div>
                                                      <div class="pt-1">
                                                          <p class="fw-bold mb-0">{{ $user['name'] }}</p>
                                                          <p class="small text-muted">{{ $user['message'] }}</p>
                                                      </div>
                                                  </div>
                                                  <div class="pt-1">
                                                      <p class="small text-muted mb-1">{{ $user['time'] }}</p>
                                                      @if ($user['badge'])
                                                          <span class="badge bg-danger rounded-pill float-end">{{ $user['badge'] }}</span>
                                                      @endif
                                                  </div>
                                              </a>
                                          </li>
                                      @endforeach
                                  </ul>
                              </div>
                          </div>
                      </div>

                      <div class="col-md-6 col-lg-7 col-xl-8">
                          <div class="pt-3 pe-3" data-mdb-perfect-scrollbar-init style="position: relative; height: 400px">
                              @foreach ($messages as $message)
                                  <div class="d-flex flex-row justify-content-{{ $message['side'] == 'left' ? 'start' : 'end' }}">
                                      @if ($message['side'] == 'left')
                                          <img src="{{ $message['avatar'] }}" alt="avatar" style="width: 45px; height: 100%;">
                                      @endif
                                      <div>
                                          <p class="small p-2 {{ $message['side'] == 'left' ? 'ms-3' : 'me-3' }} mb-1 rounded-3 {{ $message['side'] == 'left' ? 'bg-body-tertiary' : 'text-white bg-primary' }}">
                                              {{ $message['text'] }}
                                          </p>
                                          <p class="small {{ $message['side'] == 'left' ? 'ms-3' : 'me-3' }} mb-3 rounded-3 text-muted float-end">{{ $message['time'] }}</p>
                                      </div>
                                      @if ($message['side'] == 'right')
                                          <img src="{{ $message['avatar'] }}" alt="avatar" style="width: 45px; height: 100%;">
                                      @endif
                                  </div>
                              @endforeach
                          </div>

                          <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                              <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava6-bg.webp" alt="avatar 3" style="width: 40px; height: 100%;">
                              <input type="text" class="form-control form-control-lg" id="exampleFormControlInput2" placeholder="Type message">
                              <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                              <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                              <a class="ms-3" href="#!"><i class="fas fa-paper-plane"></i></a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
