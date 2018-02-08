import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params } from '@angular/router';

import { ApiService } from '../api.service';
import { ErrorService } from '../error.service';

@Component ({
  selector: 'album',
  templateUrl: './album.component.html',
  styleUrls: ['./album.component.css']
})

export class AlbumComponent implements OnInit {

  /**
   * Variable to store the results.
   * Variables for parameters for request.
   *
   * @var mixed
   */
  private results: Object;
  private url: string = 'album';

  constructor (
    private api: ApiService,
    private error: ErrorService,
    private route: ActivatedRoute
  ) {}

  ngOnInit () {
    this.route.params.forEach (
      (params: Params) => {
        this.results = null;
        this.getAlbum ()
      }
    );
  }

  /**
   * Send request to fetch data about album id.
   *
   * @param  void
   * @return void
   */
  getAlbum (): void {
    const id = this.route.snapshot.paramMap.get ('id');
    this.api.fetchData (this.url, { 'id': id }).subscribe (
      data => this.results = data,
      error => this.error.formatError (error)
    );
  }
}
