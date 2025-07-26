<div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content custom-modal">
      <div class="modal-hapus text-danger">
        <i class="fa-solid fa-right-from-bracket"></i>
      </div>
      <div class="modal-body text-center">
        <h5 class="modal-title mb-3" id="confirmLogoutLabel">Logout</h5>
        <p>Yakin ingin logout dari akun Anda?</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
        <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="d-inline">
          @csrf
          <button type="submit" class="btn btn-danger btn-hapus">Logout</button>
        </form>
      </div>
    </div>
  </div>
</div>
