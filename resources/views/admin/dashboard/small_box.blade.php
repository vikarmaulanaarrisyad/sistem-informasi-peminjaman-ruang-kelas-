<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box h-3">
            <div class="ribbon-wrapper">
                <div class="ribbon bg-primary">
                    PHB
                </div>
            </div>
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Mahasiswa</span>
                <span class="info-box-number">
                    {{ $totalMahasiswa }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box h-3">
            <div class="ribbon-wrapper">
                <div class="ribbon bg-primary">
                    PHB
                </div>
            </div>
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Dosen</span>
                <span class="info-box-number">
                    {{ $totalDosen }}
                </span>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <div class="ribbon-wrapper">
                <div class="ribbon bg-primary">
                    PHB
                </div>
            </div>
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-university"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Ruang</span>
                <span class="info-box-number">{{ $totalRuang }}</span>
            </div>

        </div>

    </div>


    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <div class="ribbon-wrapper">
                <div class="ribbon bg-primary">
                    PHB
                </div>
            </div>
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-graduation-cap"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Kelas</span>
                <span class="info-box-number">{{ $totalKelas }}</span>
            </div>
        </div>
    </div>
</div>
