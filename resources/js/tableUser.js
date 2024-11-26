import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import ResponsivePagination from 'react-responsive-pagination';
import 'react-responsive-pagination/themes/classic.css';

const TableUser = ({ data, totalItems }) => {
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  const [currentPage, setCurrentPage] = useState(1);
  const [currentData, setCurrentData] = useState(data);
  const [searchData, setSearchData] = useState('');

  const dataPerPage = 10;
  const totalPages = Math.ceil(totalItems / dataPerPage);

  const search = currentData.filter(item => item.username.includes(searchData) || item.alamat.includes(searchData));

  useEffect(() => {
    const startIndex = (currentPage - 1) * dataPerPage;
    const endIndex = startIndex + dataPerPage;

    setCurrentData(data.slice(startIndex, endIndex));
  }, [currentPage, data, totalItems]);

  const handlePageChange = page => {
    setCurrentPage(page);
  };

  return (
    <>
      <div className='row justify-content-end mb-4'>
        <div className='col-md-2 mt-2'>
          <label>Cari:</label>
          <input
            type='text'
            className='brutal-input'
            value={searchData}
            onChange={e => setSearchData(e.target.value)}
          />
        </div>
      </div>
      <div className='table-responsive text-nowrap'>
        <table className='table'>
          <thead>
            <tr>
              <th>No.</th>
              <th>Username</th>
              <th>Alamat</th>
              <th>Status</th>
              <th>Kewenangan</th>
              <th>Aksi</th>
            </tr>
          </thead>
          {search.length > 0 ? (
            search.map((item, index) => (
              <tbody className='table-border-bottom-0'>
                <tr key={index}>
                  <td>{index + 1}</td>
                  <td>
                    <div className='row'>
                      <div className='col-md-4'>
                        <div className='avatar avatar-md me-2'>
                          <img
                            src={item.url_foto == '' ? 'assets/img/avatars/5.png' : item.url_foto}
                            alt='Avatar'
                            className='rounded-circle'
                          />
                        </div>
                      </div>
                      <div className='col-md-4 mt-3'>{item.username}</div>
                    </div>
                  </td>
                  <td>{item.alamat}</td>
                  <td>
                    <span
                      className={`brutal-badge rounded-pill ${
                        item.status == 1 ? 'brutal-label-success ' : 'brutal-label-danger'
                      } me-1`}
                    >
                      {item.status == 1 ? 'Aktif' : 'Tidak Aktif'}
                    </span>
                  </td>
                  <td>
                    <span className='text-truncate d-flex align-items-center'>
                      <i
                        className={`mdi ${
                          item.kewenangan_id === 1
                            ? 'mdi-laptop'
                            : item.kewenangan_id === 2
                            ? 'mdi-shield-account'
                            : 'mdi-account'
                        } mdi-20px me-2`}
                      />
                      {item.kewenangan_id == 1 ? 'Superadmin' : item.kewenangan_id == 2 ? 'Admin' : 'User'}
                    </span>
                  </td>
                  <td width='10%'>
                    {item.face_id == null ? (
                      <a href={'/registrasi_fr/' + item.id} className='bg-menu-theme btn-brutal-primary me-2'>
                        <i className='mdi mdi-face-recognition'></i>&nbsp;Registrasi FR
                      </a>
                    ) : (
                      ''
                    )}
                    <a href={'/edit_user/' + item.id} className='bg-menu-theme btn-brutal-secondary me-2'>
                      <i className='mdi mdi-account-edit'></i>&nbsp;Edit
                    </a>
                    <form action={'/hapus_user/' + item.id} method='POST' className='d-inline'>
                      <input type='hidden' name='_token' value={csrfToken} />
                      <button type='submit' className='bg-menu-theme btn-brutal-danger' id='hapus_user'>
                        <i className='mdi mdi-delete-circle-outline'></i>&nbsp;Hapus
                      </button>
                    </form>
                  </td>
                </tr>
              </tbody>
            ))
          ) : (
            <tbody>
              <tr>
                <td colSpan='6' className='text-center'>
                  Data Tidak Ada
                </td>
              </tr>
            </tbody>
          )}
        </table>
      </div>
      <ResponsivePagination current={currentPage} total={totalPages} onPageChange={handlePageChange} />
    </>
  );
};

window.initUserTable = (containerId, data, total, search) => {
  const container = document.getElementById(containerId);
  if (container) {
    const root = createRoot(container);
    root.render(<TableUser data={data} totalItems={total} filter={search} />);
  } else {
    console.error(`id "${containerId}" tidak ada`);
  }
};
